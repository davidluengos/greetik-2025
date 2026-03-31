<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ProductForm;
use App\Models\SitePage;
use App\Support\ProductForms\DefaultProductFormFields;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function sobreNosotros(): View
    {
        $page = SitePage::query()
            ->where('slug', 'sobre-nosotros')
            ->where('is_active', true)
            ->firstOrFail();

        return view('front.sobre-nosotros', compact('page'));
    }

    public function contacto(): View
    {
        $page = SitePage::query()
            ->where('slug', 'contacto')
            ->where('is_active', true)
            ->firstOrFail();

        $extra = $page->extra ?? [];
        $formModel = $this->resolveContactFormModel($extra);

        return view('front.contacto', compact('page', 'formModel'));
    }

    public function submitContacto(Request $request): RedirectResponse
    {
        $page = SitePage::query()
            ->where('slug', 'contacto')
            ->where('is_active', true)
            ->firstOrFail();

        $formModel = $this->resolveContactFormModel($page->extra ?? []);
        $fields = is_array($formModel->fields) ? $formModel->fields : [];

        // Honeypot: los bots suelen rellenarlo.
        if ((string) $request->input('website', '') !== '') {
            return back()->with('status', 'Mensaje enviado correctamente.');
        }

        $validator = Validator::make($request->all(), $this->buildValidationRules($fields), [], $this->buildValidationAttributes($fields));

        $validator->after(function ($validator) use ($request): void {
            $startedAt = (int) $request->input('form_started_at', 0);
            if ($startedAt > 0 && (time() - $startedAt) < 2) {
                $validator->errors()->add('form', 'Tiempo de envío no válido. Inténtalo de nuevo.');
            }
        });

        $validated = $validator->validate();

        if (! $this->passesRecaptcha($request)) {
            return back()
                ->withInput()
                ->withErrors(['form' => 'No se pudo validar el antispam. Vuelve a intentarlo.']);
        }

        $to = env('CONTACT_FORM_TO', config('mail.from.address'));
        $subject = 'Nuevo mensaje de contacto - '.config('app.name');
        $replyTo = null;
        $lines = [];

        foreach ($fields as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $label = (string) ($field['label'] ?? ucfirst($name));
            $value = (string) ($validated[$name] ?? '');
            if ($value === '') {
                continue;
            }

            if (($field['type'] ?? '') === 'email' && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $replyTo = $value;
            }

            $lines[] = $label.': '.$value;
        }

        $body = implode(PHP_EOL, $lines);

        Mail::raw($body, function ($message) use ($to, $subject, $replyTo): void {
            $message->to($to)->subject($subject);
            if ($replyTo) {
                $message->replyTo($replyTo);
            }
        });

        return back()->with('status', 'Gracias, hemos recibido tu mensaje.');
    }

    public function showLegalPage(string $slug): View
    {
        if (! in_array($slug, SitePage::legalSlugs(), true)) {
            abort(404);
        }

        $page = SitePage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('front.legal-page', compact('page'));
    }

    private function resolveContactFormModel(array $extra): ProductForm
    {
        $formModel = null;
        if (! empty($extra['product_form_id'])) {
            $formModel = ProductForm::query()
                ->where('id', $extra['product_form_id'])
                ->where('is_active', true)
                ->first();
        }

        if (! $formModel) {
            $formModel = new ProductForm([
                'title' => $extra['form_heading'] ?? 'Envianos un mensaje',
                'intro' => null,
                'action_url' => route('contacto.submit'),
                'button_label' => 'Enviar',
                'fields' => DefaultProductFormFields::get(),
                'is_active' => true,
            ]);
        }

        return $formModel;
    }

    private function buildValidationRules(array $fields): array
    {
        $rules = [
            'website' => ['nullable', 'string', 'max:0'],
            'form_started_at' => ['nullable', 'integer'],
        ];

        if (config('services.recaptcha.enabled')) {
            $rules['g-recaptcha-response'] = ['required', 'string'];
        }

        foreach ($fields as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $type = (string) ($field['type'] ?? 'text');
            $isRequired = ! empty($field['required']);

            $fieldRules = [$isRequired ? 'required' : 'nullable', 'string', 'max:5000'];
            if ($type === 'email') {
                $fieldRules[] = 'email';
                $fieldRules[] = 'max:255';
            }

            $rules[$name] = $fieldRules;
        }

        return $rules;
    }

    private function buildValidationAttributes(array $fields): array
    {
        $attributes = [];
        foreach ($fields as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name !== '') {
                $attributes[$name] = (string) ($field['label'] ?? ucfirst($name));
            }
        }

        return $attributes;
    }

    private function passesRecaptcha(Request $request): bool
    {
        if (! config('services.recaptcha.enabled')) {
            return true;
        }

        $token = (string) $request->input('g-recaptcha-response', '');
        $secret = (string) config('services.recaptcha.secret_key');
        if ($token === '' || $secret === '') {
            return false;
        }

        $response = Http::asForm()->timeout(8)->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        if (! $response->ok()) {
            return false;
        }

        $data = $response->json();
        if (! ($data['success'] ?? false)) {
            return false;
        }

        if (isset($data['score'])) {
            return (float) $data['score'] >= (float) config('services.recaptcha.min_score', 0.5);
        }

        return true;
    }
}

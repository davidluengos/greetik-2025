<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\AutomatizaAnalyzeRequest;
use App\Http\Requests\Front\AutomatizaLeadRequest;
use App\Models\AutomationAssessment;
use App\Services\Automatiza\AutomatizaAnalytics;
use App\Services\Automatiza\AutomationAnalyzer;
use App\Services\Automatiza\AutomationInput;
use App\Services\Automatiza\AutomationResult;
use App\Services\Automatiza\ProcessRecommendation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AutomatizaController extends Controller
{
    public function __construct(
        private readonly AutomationAnalyzer $analyzer,
        private readonly AutomatizaAnalytics $analytics,
    ) {
    }

    public function landing(): View
    {
        $this->analytics->track('landing_viewed', ['url' => request()->fullUrl()]);

        return view('front.automatiza.index', [
            'faqs' => $this->faqs(),
        ]);
    }

    public function wizard(): View
    {
        $this->analytics->track('wizard_started');

        return view('front.automatiza.wizard', [
            'config' => $this->publicConfig(),
        ]);
    }

    public function analyze(AutomatizaAnalyzeRequest $request): RedirectResponse
    {
        $input = AutomationInput::fromArray($request->validated());
        $result = $this->analyzer->analyze($input);

        $assessment = AutomationAssessment::create(array_merge(
            $input->toArray(),
            $result->toStorageArray(),
            [
                'ip' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'referrer' => (string) $request->headers->get('referer'),
            ],
        ));

        $this->analytics->track('wizard_completed', [
            'uuid' => $assessment->uuid,
            'sector' => $assessment->sector,
            'score' => $result->score,
            'solution' => $result->recommendedSolutionKey,
        ]);

        return redirect()->route('automatiza.result', ['assessment' => $assessment->uuid]);
    }

    public function result(AutomationAssessment $assessment): View
    {
        $result = $this->hydrateResult($assessment);

        $this->analytics->track('result_viewed', [
            'uuid' => $assessment->uuid,
            'score' => $assessment->score,
        ]);

        return view('front.automatiza.resultado', [
            'assessment' => $assessment,
            'result' => $result,
            'inputLabels' => $this->humanizedInput($assessment),
        ]);
    }

    public function contact(AutomationAssessment $assessment, AutomatizaLeadRequest $request): RedirectResponse
    {
        if ((string) $request->input('website', '') !== '') {
            return redirect()->route('automatiza.result', ['assessment' => $assessment->uuid])
                ->with('status', 'Gracias, hemos recibido tu solicitud.');
        }


        $validated = $request->validated();

        $assessment->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'privacy_accepted' => true,
            'contacted_at' => now(),
        ])->save();

        $this->analytics->track('lead_captured', [
            'uuid' => $assessment->uuid,
            'sector' => $assessment->sector,
        ]);

        $this->notifyTeam($assessment);

        return redirect()->route('automatiza.result', ['assessment' => $assessment->uuid])
            ->with('status', 'Gracias, hemos recibido tu solicitud. Nos pondremos en contacto contigo pronto.')
            ->withFragment('contacto');
    }

    public function sector(string $slug): View
    {
        $pages = (array) config('automatiza.sector_pages', []);
        if (! isset($pages[$slug])) {
            abort(404);
        }

        $this->analytics->track('sector_viewed', ['sector' => $slug]);

        return view('front.automatiza.sector', [
            'slug' => $slug,
            'page' => $pages[$slug],
        ]);
    }

    public function ctaTracker(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->analytics->track('cta_clicked', [
            'label' => (string) $request->input('label', ''),
            'context' => (string) $request->input('context', ''),
        ]);

        return response()->json(['ok' => true]);
    }

    private function hydrateResult(AutomationAssessment $assessment): AutomationResult
    {
        // Reconstruimos el AutomationResult desde el registro persistido para
        // que la vista use siempre el mismo DTO independientemente de si el
        // usuario acaba de completar el wizard o vuelve por la URL.
        $input = AutomationInput::fromArray([
            'sector' => $assessment->sector,
            'sector_other' => $assessment->sector_other,
            'company_size' => $assessment->company_size,
            'tools' => $assessment->tools ?? [],
            'repetitive_hours' => $assessment->repetitive_hours,
            'customer_management' => $assessment->customer_management,
            'quotations' => $assessment->quotations,
            'follow_up' => $assessment->follow_up,
            'documents' => $assessment->documents ?? [],
            'communication' => $assessment->communication ?? [],
            'main_problem' => $assessment->main_problem,
            'hourly_cost' => $assessment->hourly_cost,
        ]);

        return $this->analyzer->analyze($input);
    }

    private function notifyTeam(AutomationAssessment $assessment): void
    {
        $to = env('AUTOMATIZA_LEAD_TO', env('CONTACT_FORM_TO', config('mail.from.address')));
        if (empty($to)) {
            return;
        }

        $lines = [
            'Nuevo lead de Greetik Automatiza',
            str_repeat('-', 40),
            'Nombre: '.$assessment->name,
            'Email: '.$assessment->email,
            'Empresa: '.($assessment->company ?: '-'),
            'Teléfono: '.($assessment->phone ?: '-'),
            'Sector: '.($assessment->sector ?: '-'),
            'Tamaño: '.($assessment->company_size ?: '-'),
            'Score: '.$assessment->score.' ('.$assessment->score_level.')',
            'Ahorro anual estimado: '.$assessment->estimated_annual_saving.' €',
            'Solución: '.$assessment->recommended_solution_key,
            'Inversión: '.$assessment->estimated_investment_min.' - '.$assessment->estimated_investment_max.' €',
            'Ver resultado: '.route('automatiza.result', ['assessment' => $assessment->uuid]),
        ];

        try {
            Mail::raw(implode(PHP_EOL, $lines), function ($message) use ($to, $assessment): void {
                $message->to($to)->subject('Nuevo lead Automatiza - '.($assessment->company ?: $assessment->name));
                if ($assessment->email) {
                    $message->replyTo($assessment->email, $assessment->name ?? null);
                }
            });
        } catch (\Throwable $e) {
            Log::error('automatiza: no se pudo enviar la notificación de lead', [
                'uuid' => $assessment->uuid,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function publicConfig(): array
    {
        return [
            'sectors' => (array) config('automatiza.sectors', []),
            'company_sizes' => (array) config('automatiza.company_sizes', []),
            'tools' => (array) config('automatiza.tools', []),
            'repetitive_hours' => array_map(
                static fn (array $entry): string => (string) ($entry['label'] ?? ''),
                (array) config('automatiza.repetitive_hours', []),
            ),
            'customer_management' => (array) config('automatiza.customer_management', []),
            'quotations' => (array) config('automatiza.quotations', []),
            'follow_up' => (array) config('automatiza.follow_up', []),
            'documents' => (array) config('automatiza.documents', []),
            'communication' => (array) config('automatiza.communication', []),
            'hourly_costs' => array_map(
                static fn (array $entry): string => (string) ($entry['label'] ?? ''),
                (array) config('automatiza.hourly_costs', []),
            ),
        ];
    }

    private function humanizedInput(AutomationAssessment $assessment): array
    {
        $labels = $this->publicConfig();

        $map = static function (array $labelMap, ?string $value): ?string {
            if (! $value) {
                return null;
            }
            return $labelMap[$value] ?? null;
        };

        $mapList = static function (array $labelMap, ?array $values): array {
            $out = [];
            foreach ((array) $values as $value) {
                if (isset($labelMap[$value])) {
                    $out[] = $labelMap[$value];
                }
            }
            return $out;
        };

        return [
            'sector' => $map($labels['sectors'], $assessment->sector),
            'company_size' => $map($labels['company_sizes'], $assessment->company_size),
            'tools' => $mapList($labels['tools'], $assessment->tools),
            'repetitive_hours' => $map($labels['repetitive_hours'], $assessment->repetitive_hours),
            'customer_management' => $map($labels['customer_management'], $assessment->customer_management),
            'quotations' => $map($labels['quotations'], $assessment->quotations),
            'follow_up' => $map($labels['follow_up'], $assessment->follow_up),
            'documents' => $mapList($labels['documents'], $assessment->documents),
            'communication' => $mapList($labels['communication'], $assessment->communication),
            'hourly_cost' => $map($labels['hourly_costs'], $assessment->hourly_cost),
        ];
    }

    private function faqs(): array
    {
        return [
            [
                'q' => '¿Es realmente gratis?',
                'a' => 'Sí. La herramienta es totalmente gratuita y no requiere registro para obtener el resultado. Solo pedimos datos de contacto si prefieres recibir el informe por email o quieres que estudiemos tu caso.',
            ],
            [
                'q' => '¿Necesito conocimientos técnicos para usarla?',
                'a' => 'No. Todas las preguntas son sobre cómo trabajas actualmente. En 2-3 minutos tendrás el análisis con horas y euros que podrías ahorrar y por qué procesos empezar.',
            ],
            [
                'q' => '¿Cómo calculáis el ahorro?',
                'a' => 'A partir de las horas que dedicas a tareas repetitivas y su coste, aplicamos un porcentaje de ahorro conservador según el resto de respuestas. Preferimos quedarnos cortos a prometer ahorros irreales.',
            ],
            [
                'q' => '¿Voy a recibir mucha publicidad después?',
                'a' => 'No. Si no dejas tus datos, no te podemos contactar. Si los dejas, solo te escribimos para lo que has solicitado.',
            ],
            [
                'q' => '¿La inversión que mostráis es un presupuesto de Greetik?',
                'a' => 'No. Es un rango orientativo de mercado para ayudarte a valorar si merece la pena estudiar el proyecto. El coste real depende de funcionalidades, integraciones y complejidad.',
            ],
        ];
    }
}

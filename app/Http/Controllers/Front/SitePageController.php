<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ProductForm;
use App\Models\SitePage;
use App\Support\ProductForms\DefaultProductFormFields;
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
        $formModel = null;
        if (!empty($extra['product_form_id'])) {
            $formModel = ProductForm::query()
                ->where('id', $extra['product_form_id'])
                ->where('is_active', true)
                ->first();
        }

        if (!$formModel) {
            $formModel = new ProductForm([
                'title' => $extra['form_heading'] ?? 'Envianos un mensaje',
                'intro' => null,
                'action_url' => '#',
                'button_label' => 'Enviar',
                'fields' => DefaultProductFormFields::get(),
                'is_active' => true,
            ]);
        }

        return view('front.contacto', compact('page', 'formModel'));
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
}

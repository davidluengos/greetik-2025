<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductForm;
use App\Models\SitePage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SitePageController extends Controller
{
    public function index()
    {
        $pages = SitePage::query()
            ->orderByRaw("CASE slug
                WHEN 'sobre-nosotros' THEN 0
                WHEN 'contacto' THEN 1
                WHEN 'aviso-legal' THEN 2
                WHEN 'politica-de-privacidad' THEN 3
                WHEN 'politica-de-cookies' THEN 4
                WHEN 'terminos-y-condiciones' THEN 5
                ELSE 99 END")
            ->orderBy('title')
            ->get();

        return view('admin.site-pages.index', compact('pages'));
    }

    public function edit(SitePage $site_page)
    {
        $productForms = ProductForm::query()->orderBy('name')->get(['id', 'name', 'is_active']);

        return view('admin.site-pages.edit', [
            'page' => $site_page,
            'productForms' => $productForms,
        ]);
    }

    public function update(Request $request, SitePage $site_page)
    {
        if ($site_page->slug === 'contacto') {
            $request->merge([
                'product_form_id' => $request->filled('product_form_id') ? $request->integer('product_form_id') : null,
            ]);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'address_title' => ['nullable', 'string', 'max:120'],
            'address' => ['nullable', 'string'],
            'hours_title' => ['nullable', 'string', 'max:120'],
            'hours' => ['nullable', 'string'],
            'phones_title' => ['nullable', 'string', 'max:120'],
            'phones_text' => ['nullable', 'string'],
            'form_heading' => ['nullable', 'string', 'max:255'],
            'map_embed' => ['nullable', 'string'],
            'product_form_id' => ['nullable', 'integer', Rule::exists('product_forms', 'id')],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'carousel_json' => ['nullable', 'string'],
        ]);

        $site_page->title = $data['title'];
        $site_page->meta_title = $data['meta_title'] ?? null;
        $site_page->meta_description = $data['meta_description'] ?? null;
        $site_page->body = $data['body'] ?? null;
        $site_page->is_active = $request->boolean('is_active');

        $extra = $site_page->extra ?? [];

        if ($site_page->slug === 'contacto') {
            $extra['address_title'] = $data['address_title'] ?? '';
            $extra['address'] = $data['address'] ?? '';
            $extra['hours_title'] = $data['hours_title'] ?? '';
            $extra['hours'] = $data['hours'] ?? '';
            $extra['phones_title'] = $data['phones_title'] ?? '';
            $lines = preg_split('/\r\n|\r|\n/', (string) ($data['phones_text'] ?? ''));
            $extra['phones'] = array_values(array_filter(array_map('trim', $lines)));
            $extra['form_heading'] = $data['form_heading'] ?? '';
            $extra['map_embed'] = $data['map_embed'] ?? '';
            $extra['product_form_id'] = $data['product_form_id'] ?? null;
        }

        if ($site_page->slug === 'sobre-nosotros') {
            $extra['hero_image'] = $data['hero_image'] ?? '';
            $decoded = json_decode($data['carousel_json'] ?? '[]', true);
            $extra['carousel'] = is_array($decoded) ? $decoded : [];
        }

        $site_page->extra = $extra;
        $site_page->save();

        return redirect()->route('admin.site-pages.index')->with('status', 'Pagina actualizada correctamente.');
    }
}

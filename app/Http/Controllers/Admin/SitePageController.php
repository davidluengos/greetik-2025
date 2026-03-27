<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSitePageRequest;
use App\Models\ProductForm;
use App\Models\SitePage;
use App\Services\SitePages\SitePageUpdater;

class SitePageController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', SitePage::class);
        $pages = SitePage::query()
            ->orderByRaw("CASE slug
                WHEN 'sobre-nosotros' THEN 0
                WHEN 'contacto' THEN 1
                WHEN 'portfolio' THEN 2
                WHEN 'aviso-legal' THEN 3
                WHEN 'politica-de-privacidad' THEN 4
                WHEN 'politica-de-cookies' THEN 5
                WHEN 'terminos-y-condiciones' THEN 6
                ELSE 99 END")
            ->orderBy('title')
            ->get();

        return view('admin.site-pages.index', compact('pages'));
    }

    public function edit(SitePage $site_page)
    {
        $this->authorize('update', $site_page);
        $productForms = ProductForm::query()->orderBy('name')->get(['id', 'name', 'is_active']);

        return view('admin.site-pages.edit', [
            'page' => $site_page,
            'productForms' => $productForms,
        ]);
    }

    public function update(UpdateSitePageRequest $request, SitePage $site_page, SitePageUpdater $sitePageUpdater)
    {
        $this->authorize('update', $site_page);
        $sitePageUpdater->update(
            $site_page,
            $request->validated(),
            $request->boolean('is_active')
        );

        return redirect()->route('admin.site-pages.index')->with('status', 'Pagina actualizada correctamente.');
    }
}

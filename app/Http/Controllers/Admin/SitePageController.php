<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSitePageRequest;
use App\Models\ProductForm;
use App\Models\SitePage;
use App\Services\SitePages\SitePageUpdater;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SitePageController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', SitePage::class);
        $pages = SitePage::query()
            ->orderByRaw("CASE slug
                WHEN 'home' THEN -1
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
        $data = $request->validated();
        if ($site_page->slug === 'home') {
            $data = $this->mergeHomeHeroBackgroundUpload($request, $site_page, $data);
        }
        $sitePageUpdater->update(
            $site_page,
            $data,
            $request->boolean('is_active')
        );

        return redirect()->route('admin.site-pages.index')->with('status', 'Pagina actualizada correctamente.');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mergeHomeHeroBackgroundUpload(UpdateSitePageRequest $request, SitePage $sitePage, array $data): array
    {
        $extra = is_array($sitePage->extra) ? $sitePage->extra : [];
        $currentBg = (string) ($extra['hero_background_image'] ?? '');

        $file = $request->file('hero_background_image_file');
        if ($file instanceof UploadedFile) {
            $this->deleteStoredPublicHomeHeroImage($currentBg);
            $path = $file->store('home-hero', 'public');
            $data['hero_background_image'] = 'storage/'.$path;

            return $data;
        }

        if ($request->boolean('clear_hero_background_image')) {
            $this->deleteStoredPublicHomeHeroImage($currentBg);
            $data['hero_background_image'] = '';
        }

        return $data;
    }

    private function deleteStoredPublicHomeHeroImage(string $storedPath): void
    {
        if ($storedPath !== '' && Str::startsWith($storedPath, 'storage/')) {
            Storage::disk('public')->delete(Str::after($storedPath, 'storage/'));
        }
    }
}

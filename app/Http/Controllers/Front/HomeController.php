<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SitePage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $page = SitePage::query()
            ->where('slug', 'home')
            ->where('is_active', true)
            ->first();

        $extra = is_array($page?->extra) ? $page->extra : [];
        $hero = [
            'title' => $extra['hero_title'] ?? 'GREETIK Soluciones',
            'subtitle' => $extra['hero_subtitle'] ?? 'Desarrollo Web Profesional',
            'text' => $extra['hero_text'] ?? 'Creamos páginas web, tiendas online y aplicaciones a medida para impulsar tu negocio.',
            'image' => $extra['hero_image'] ?? 'front/img/parallax-slider/images/desarrollo.png',
            'primary_cta_text' => filled($extra['hero_primary_cta_text'] ?? null)
                ? $extra['hero_primary_cta_text']
                : 'Pide presupuesto',
            'primary_cta_url' => filled($extra['hero_primary_cta_url'] ?? null)
                ? $extra['hero_primary_cta_url']
                : route('contacto'),
            'secondary_cta_text' => filled($extra['hero_secondary_cta_text'] ?? null)
                ? $extra['hero_secondary_cta_text']
                : '',
            'secondary_cta_url' => filled($extra['hero_secondary_cta_url'] ?? null)
                ? $extra['hero_secondary_cta_url']
                : '',
            'background_image' => filled($extra['hero_background_image'] ?? null)
                ? (string) $extra['hero_background_image']
                : null,
            'background_color' => $this->normalizedHeroBackgroundColor($extra),
        ];

        $homeServices = Service::query()
            ->where('is_active', true)
            ->where('show_on_home', true)
            ->orderBy('home_order')
            ->orderBy('menu_order')
            ->orderBy('title')
            ->get();

        return view('front.home', [
            'page' => $page,
            'hero' => $hero,
            'homeServices' => $homeServices,
        ]);
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    private function normalizedHeroBackgroundColor(array $extra): string
    {
        $raw = trim((string) ($extra['hero_background_color'] ?? ''));
        if ($raw !== '' && preg_match('/^#(?:[\da-fA-F]{3}|[\da-fA-F]{6}|[\da-fA-F]{8})$/', $raw)) {
            return $raw;
        }

        return '#e9ecef';
    }
}

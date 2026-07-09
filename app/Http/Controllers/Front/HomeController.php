<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\SitePage;
use App\Models\Testimonial;
use App\Support\Home\DefaultValueProps;
use App\Support\Home\HomeSections;
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

        $sections = HomeSections::activeOrderedKeys($extra);

        $homeServices = collect();
        if (in_array('services', $sections, true)) {
            $homeServices = Service::query()
                ->where('is_active', true)
                ->where('show_on_home', true)
                ->orderBy('home_order')
                ->orderBy('menu_order')
                ->orderBy('title')
                ->get();
        }

        $featuredProducts = collect();
        if (in_array('featured_products', $sections, true)) {
            $featuredProducts = Project::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('menu_order')
                ->orderBy('title')
                ->get();
        }

        $testimonials = collect();
        if (in_array('testimonials', $sections, true)) {
            $testimonials = Testimonial::query()
                ->where('is_active', true)
                ->orderBy('menu_order')
                ->orderBy('author')
                ->get();
        }

        $valueProps = isset($extra['value_props']) && is_array($extra['value_props']) && $extra['value_props'] !== []
            ? array_values($extra['value_props'])
            : DefaultValueProps::get();

        $sectionText = [
            'featured_products_label' => filled($extra['featured_products_label'] ?? null)
                ? (string) $extra['featured_products_label']
                : 'Producto destacado',
            'testimonials_title' => filled($extra['testimonials_title'] ?? null)
                ? (string) $extra['testimonials_title']
                : 'Opiniones de clientes',
            'value_props_title' => filled($extra['value_props_title'] ?? null)
                ? (string) $extra['value_props_title']
                : DefaultValueProps::TITLE,
        ];

        return view('front.home', [
            'page' => $page,
            'hero' => $hero,
            'sections' => $sections,
            'homeServices' => $homeServices,
            'featuredProducts' => $featuredProducts,
            'testimonials' => $testimonials,
            'valueProps' => $valueProps,
            'sectionText' => $sectionText,
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

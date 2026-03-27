<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
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
            'primary_cta_text' => $extra['hero_primary_cta_text'] ?? 'Pide presupuesto',
            'primary_cta_url' => $extra['hero_primary_cta_url'] ?? route('contacto'),
        ];

        return view('front.home', [
            'page' => $page,
            'hero' => $hero,
        ]);
    }
}

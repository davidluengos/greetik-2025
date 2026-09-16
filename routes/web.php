<?php

use App\Http\Controllers\Front\AutomatizaController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LegacyRedirectController;
use App\Http\Controllers\Front\PortfolioController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\SeccionesController;
use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\Front\SitePageController;
use App\Models\SitePage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/secciones/{path}', [LegacyRedirectController::class, 'handle'])
    ->where('path', '.+')
    ->name('legacy.section');

// Sistema de tags del CMS antiguo — 301 catch-all al indice del blog para consolidar
// autoridad. El CMS antiguo generaba /tag/{nombre} y /tag/{nombre}/{pagina}, hoy no
// existe sistema de tags. Ver docs/legacy-redirects.md para el porque de esta decision.
Route::get('/tag/{tag}', fn () => redirect('/blog', 301))
    ->where('tag', '.+')
    ->name('legacy.tag');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/servicios', [SeccionesController::class, 'indexServicios'])->name('servicios.index');
Route::get('/sobre-nosotros', [SitePageController::class, 'sobreNosotros'])->name('about');
Route::get('/contacto', [SitePageController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [SitePageController::class, 'submitContacto'])->name('contacto.submit');
Route::get('/productos/{slug}', [SeccionesController::class, 'showProducto'])->name('productos.show');

Route::prefix('automatiza')->name('automatiza.')->group(function () {
    Route::get('/', [AutomatizaController::class, 'landing'])->name('landing');
    Route::get('/wizard', [AutomatizaController::class, 'wizard'])->name('wizard');
    Route::post('/analizar', [AutomatizaController::class, 'analyze'])->name('analyze');
    Route::post('/cta-tracker', [AutomatizaController::class, 'ctaTracker'])->name('cta');
    Route::get('/resultado/{assessment}', [AutomatizaController::class, 'result'])->name('result');
    Route::post('/resultado/{assessment}/contacto', [AutomatizaController::class, 'contact'])->name('contact');
    Route::get('/sectores/{slug}', [AutomatizaController::class, 'sector'])
        ->where('slug', '[a-z0-9\-]+')
        ->name('sector');
});

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-]+')
    ->name('portfolio.show');

Route::get('/{slug}', [SitePageController::class, 'showLegalPage'])
    ->whereIn('slug', SitePage::legalSlugs())
    ->name('legal.page');
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');

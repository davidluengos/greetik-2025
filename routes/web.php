<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\SeccionesController;
use App\Http\Controllers\Front\SitePageController;
use App\Models\SitePage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/servicios', [SeccionesController::class, 'indexServicios'])->name('servicios.index');
Route::get('/sobre-nosotros', [SitePageController::class, 'sobreNosotros'])->name('about');
Route::get('/contacto', [SitePageController::class, 'contacto'])->name('contacto');
Route::get('/productos/{slug}', [SeccionesController::class, 'showProducto'])->name('productos.show');

Route::get('/{slug}', [SitePageController::class, 'showLegalPage'])
    ->whereIn('slug', SitePage::legalSlugs())
    ->name('legal.page');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');

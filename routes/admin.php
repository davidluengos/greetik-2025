<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioItemController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PricingTableController;
use App\Http\Controllers\Admin\ProductFormController;
use App\Http\Controllers\Admin\SiteMediaController;
use App\Http\Controllers\Admin\SitePageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TechnologyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::resource('services', ServiceController::class);
Route::resource('projects', ProjectController::class);
Route::resource('product-forms', ProductFormController::class);
Route::resource('pricing-tables', PricingTableController::class);
Route::resource('portfolio-items', PortfolioItemController::class);
Route::resource('posts', PostController::class);
Route::get('site-media/picker-items', [SiteMediaController::class, 'pickerItems'])->name('site-media.picker-items');
Route::get('site-media', [SiteMediaController::class, 'index'])->name('site-media.index');
Route::post('site-media', [SiteMediaController::class, 'store'])->name('site-media.store');
Route::patch('site-media/{siteMedia}', [SiteMediaController::class, 'update'])->name('site-media.update');
Route::delete('site-media/{siteMedia}', [SiteMediaController::class, 'destroy'])->name('site-media.destroy');
Route::resource('tags', TagController::class);
Route::resource('technologies', TechnologyController::class);
Route::get('site-pages', [SitePageController::class, 'index'])->name('site-pages.index');
Route::get('site-pages/{site_page}/edit', [SitePageController::class, 'edit'])->name('site-pages.edit');
Route::put('site-pages/{site_page}', [SitePageController::class, 'update'])->name('site-pages.update');
Route::post('posts/meta-description-ai', [PostController::class, 'generateMetaDescriptionAi'])->name('posts.meta-description-ai');

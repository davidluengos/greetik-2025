<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioItemController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::resource('services', ServiceController::class);
Route::resource('projects', ProjectController::class);
Route::resource('portfolio-items', PortfolioItemController::class);
Route::resource('posts', PostController::class);
Route::resource('tags', TagController::class);
Route::post('posts/meta-description-ai', [PostController::class, 'generateMetaDescriptionAi'])->name('posts.meta-description-ai');

<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('front.layouts.header', function ($view): void {
            $menuServices = collect();
            $menuProjects = collect();

            if (Schema::hasTable('services')) {
                $menuServices = Service::query()
                    ->where('is_active', true)
                    ->orderBy('menu_order')
                    ->orderBy('title')
                    ->get(['title', 'slug']);
            }

            if (Schema::hasTable('projects')) {
                $menuProjects = Project::query()
                    ->where('is_active', true)
                    ->orderBy('menu_order')
                    ->orderBy('title')
                    ->get(['title', 'slug']);
            }

            $view->with([
                'menuServices' => $menuServices,
                'menuProjects' => $menuProjects,
            ]);
        });
    }
}

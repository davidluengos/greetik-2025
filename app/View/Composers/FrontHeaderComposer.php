<?php

namespace App\View\Composers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class FrontHeaderComposer
{
    public function compose(View $view): void
    {
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
    }
}

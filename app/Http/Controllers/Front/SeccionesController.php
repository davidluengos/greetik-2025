<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;

class SeccionesController extends Controller
{
    public function indexServicios()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('menu_order')
            ->orderBy('title')
            ->get();

        $technologies = Technology::query()
            ->where('is_active', true)
            ->orderBy('menu_order')
            ->orderBy('title')
            ->get();

        return view('front.servicios', compact('services', 'technologies'));
    }

    public function showProducto(string $slug)
    {
        $project = Project::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->with(['productForm', 'pricingTable'])
            ->firstOrFail();

        return view('front.producto', compact('project'));
    }
}

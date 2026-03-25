<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingTable;
use Illuminate\Http\Request;

class PricingTableController extends Controller
{
    public function index()
    {
        $pricingTables = PricingTable::query()
            ->orderBy('name')
            ->paginate(20);

        return view('admin.pricing-tables.index', compact('pricingTables'));
    }

    public function create()
    {
        $pricingTable = new PricingTable();

        return view('admin.pricing-tables.create', compact('pricingTable'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        PricingTable::create($data);

        return redirect()->route('admin.pricing-tables.index')->with('status', 'Tabla de precios creada correctamente.');
    }

    public function show(PricingTable $pricingTable)
    {
        return view('admin.pricing-tables.show', compact('pricingTable'));
    }

    public function edit(PricingTable $pricingTable)
    {
        return view('admin.pricing-tables.edit', compact('pricingTable'));
    }

    public function update(Request $request, PricingTable $pricingTable)
    {
        $data = $this->validatedData($request);
        $pricingTable->update($data);

        return redirect()->route('admin.pricing-tables.index')->with('status', 'Tabla de precios actualizada correctamente.');
    }

    public function destroy(PricingTable $pricingTable)
    {
        $pricingTable->delete();

        return redirect()->route('admin.pricing-tables.index')->with('status', 'Tabla de precios eliminada.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'plans' => ['nullable', 'json'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $decoded = isset($data['plans']) ? json_decode($data['plans'], true) : null;
        $data['plans'] = is_array($decoded) && $decoded !== [] ? $decoded : self::defaultPlans();

        return $data;
    }

    public static function defaultPlans(): array
    {
        return [
            [
                'name' => 'Light',
                'price' => '20 EUR',
                'description' => 'Perfecto para comenzar.',
                'features' => ['Landing page', 'Formulario de contacto', 'Soporte por email'],
                'highlighted' => false,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
            [
                'name' => 'Run',
                'price' => '50 EUR',
                'description' => 'Ideal para negocios en crecimiento.',
                'features' => ['Web corporativa', 'Blog', 'SEO basico'],
                'highlighted' => true,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
            [
                'name' => 'Fly',
                'price' => '100 EUR',
                'description' => 'Para proyectos con necesidades avanzadas.',
                'features' => ['Todo lo anterior', 'Integraciones', 'Prioridad soporte'],
                'highlighted' => false,
                'button_label' => 'Solicitar',
                'button_url' => '/contacto',
            ],
        ];
    }
}

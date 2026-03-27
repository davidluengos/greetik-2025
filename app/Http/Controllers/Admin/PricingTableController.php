<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePricingTableRequest;
use App\Http\Requests\Admin\UpdatePricingTableRequest;
use App\Models\PricingTable;
use App\Support\PricingTables\DefaultPricingPlans;

class PricingTableController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PricingTable::class, 'pricing_table');
    }

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

    public function store(StorePricingTableRequest $request)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
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

    public function update(UpdatePricingTableRequest $request, PricingTable $pricingTable)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
        $pricingTable->update($data);

        return redirect()->route('admin.pricing-tables.index')->with('status', 'Tabla de precios actualizada correctamente.');
    }

    public function destroy(PricingTable $pricingTable)
    {
        $pricingTable->delete();

        return redirect()->route('admin.pricing-tables.index')->with('status', 'Tabla de precios eliminada.');
    }

    private function validatedData(array $data, bool $isActive): array
    {
        $data['is_active'] = $isActive;
        $decoded = isset($data['plans']) ? json_decode($data['plans'], true) : null;
        $data['plans'] = is_array($decoded) && $decoded !== [] ? $decoded : DefaultPricingPlans::get();

        return $data;
    }
}

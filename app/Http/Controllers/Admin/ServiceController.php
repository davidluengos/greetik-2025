<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }

    public function index()
    {
        $services = Service::orderBy('menu_order')->orderBy('title')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service();

        return view('admin.services.create', compact('service'));
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio creado correctamente.');
    }

    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Servicio eliminado.');
    }

    private function validatedData(array $data, bool $isActive): array
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $data['is_active'] = $isActive;
        $data['menu_order'] = $data['menu_order'] ?? 0;
        $data['extra'] = isset($data['extra']) ? json_decode($data['extra'], true) : null;

        return $data;
    }
}

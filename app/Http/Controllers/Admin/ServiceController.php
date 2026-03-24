<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
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

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
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

    public function update(Request $request, Service $service)
    {
        $data = $this->validatedData($request, $service->id);
        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Servicio eliminado.');
    }

    private function validatedData(Request $request, ?int $serviceId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($serviceId),
            ],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'menu_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'extra' => ['nullable', 'json'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['menu_order'] = $data['menu_order'] ?? 0;
        $data['extra'] = isset($data['extra']) ? json_decode($data['extra'], true) : null;

        return $data;
    }
}

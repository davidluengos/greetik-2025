<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TechnologyController extends Controller
{
    public function index()
    {
        $technologies = Technology::query()
            ->orderBy('menu_order')
            ->orderBy('title')
            ->paginate(20);

        return view('admin.technologies.index', compact('technologies'));
    }

    public function create()
    {
        $technology = new Technology();

        return view('admin.technologies.create', compact('technology'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Technology::create($data);

        return redirect()->route('admin.technologies.index')->with('status', 'Tecnologia creada correctamente.');
    }

    public function show(Technology $technology)
    {
        return view('admin.technologies.show', compact('technology'));
    }

    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    public function update(Request $request, Technology $technology)
    {
        $data = $this->validatedData($request, $technology->id);
        $technology->update($data);

        return redirect()->route('admin.technologies.index')->with('status', 'Tecnologia actualizada correctamente.');
    }

    public function destroy(Technology $technology)
    {
        $technology->delete();

        return redirect()->route('admin.technologies.index')->with('status', 'Tecnologia eliminada.');
    }

    private function validatedData(Request $request, ?int $technologyId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('technologies', 'slug')->ignore($technologyId),
            ],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:120'],
            'menu_order' => ['nullable', 'integer', 'min:0'],
            'extra' => ['nullable', 'json'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['menu_order'] = $data['menu_order'] ?? 0;
        $data['extra'] = isset($data['extra']) ? json_decode($data['extra'], true) : null;

        return $data;
    }
}

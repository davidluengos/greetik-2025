<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingTable;
use App\Models\ProductForm;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('menu_order')->orderBy('title')->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $project = new Project();

        return view('admin.projects.create', $this->projectFormLists($project));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Producto creado correctamente.');
    }

    public function show(Project $project)
    {
        $project->load(['productForm', 'pricingTable']);

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', $this->projectFormLists($project));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validatedData($request, $project->id);
        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Producto eliminado.');
    }

    private function validatedData(Request $request, ?int $projectId = null): array
    {
        $request->merge([
            'product_form_id' => $request->filled('product_form_id') ? $request->integer('product_form_id') : null,
            'pricing_table_id' => $request->filled('pricing_table_id') ? $request->integer('pricing_table_id') : null,
        ]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('projects', 'slug')->ignore($projectId),
            ],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'menu_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'extra' => ['nullable', 'json'],
            'product_form_id' => ['nullable', 'integer', 'exists:product_forms,id'],
            'pricing_table_id' => ['nullable', 'integer', 'exists:pricing_tables,id'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['menu_order'] = $data['menu_order'] ?? 0;
        $data['extra'] = isset($data['extra']) ? json_decode($data['extra'], true) : null;

        return $data;
    }

    /**
     * @return array{project: Project, productForms: \Illuminate\Support\Collection, pricingTables: \Illuminate\Support\Collection}
     */
    private function projectFormLists(Project $project): array
    {
        $productForms = ProductForm::query()->orderBy('name')->get(['id', 'name', 'is_active']);
        $pricingTables = PricingTable::query()->orderBy('name')->get(['id', 'name', 'is_active']);

        return compact('project', 'productForms', 'pricingTables');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PortfolioItemController extends Controller
{
    public function index()
    {
        $portfolioItems = PortfolioItem::orderBy('menu_order')->orderBy('title')->paginate(15);

        return view('admin.portfolio-items.index', compact('portfolioItems'));
    }

    public function create()
    {
        $portfolioItem = new PortfolioItem();

        return view('admin.portfolio-items.create', compact('portfolioItem'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        PortfolioItem::create($data);

        return redirect()->route('admin.portfolio-items.index')->with('status', 'Elemento de portfolio creado correctamente.');
    }

    public function show(PortfolioItem $portfolioItem)
    {
        return view('admin.portfolio-items.show', compact('portfolioItem'));
    }

    public function edit(PortfolioItem $portfolioItem)
    {
        return view('admin.portfolio-items.edit', compact('portfolioItem'));
    }

    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $data = $this->validatedData($request, $portfolioItem->id);
        $portfolioItem->update($data);

        return redirect()->route('admin.portfolio-items.index')->with('status', 'Elemento de portfolio actualizado correctamente.');
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();

        return redirect()->route('admin.portfolio-items.index')->with('status', 'Elemento de portfolio eliminado.');
    }

    private function validatedData(Request $request, ?int $portfolioItemId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('portfolio_items', 'slug')->ignore($portfolioItemId),
            ],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'completed_at' => ['nullable', 'date'],
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioItemRequest;
use App\Http\Requests\Admin\UpdatePortfolioItemRequest;
use App\Models\PortfolioItem;
use App\Models\SitePage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PortfolioItemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PortfolioItem::class, 'portfolio_item');
    }

    public function index()
    {
        $portfolioItems = PortfolioItem::orderBy('menu_order')->orderBy('title')->paginate(15);
        $portfolioIntroPage = SitePage::query()->where('slug', 'portfolio')->first();

        return view('admin.portfolio-items.index', compact('portfolioItems', 'portfolioIntroPage'));
    }

    public function create()
    {
        $portfolioItem = new PortfolioItem();

        return view('admin.portfolio-items.create', compact('portfolioItem'));
    }

    public function store(StorePortfolioItemRequest $request)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
        $data = $this->handleImageUpload($request->file('image_file'), $data);
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

    public function update(UpdatePortfolioItemRequest $request, PortfolioItem $portfolioItem)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
        $data = $this->handleImageUpload($request->file('image_file'), $data, $portfolioItem->image);
        $portfolioItem->update($data);

        return redirect()->route('admin.portfolio-items.index')->with('status', 'Elemento de portfolio actualizado correctamente.');
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();

        return redirect()->route('admin.portfolio-items.index')->with('status', 'Elemento de portfolio eliminado.');
    }

    private function validatedData(array $data, bool $isActive): array
    {
        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        if ($data['slug'] === 'portfolio') {
            throw ValidationException::withMessages([
                'title' => 'Ese titulo o slug genera la URL reservada /portfolio. Añade un distintivo o cambia el slug.',
            ]);
        }
        $data['is_active'] = $isActive;
        $data['menu_order'] = $data['menu_order'] ?? 0;
        $data['extra'] = isset($data['extra']) ? json_decode($data['extra'], true) : null;
        unset($data['image_file']);

        return $data;
    }

    private function handleImageUpload(?UploadedFile $imageFile, array $data, ?string $oldImage = null): array
    {
        if (! $imageFile) {
            return $data;
        }

        $path = $imageFile->store('portfolio-items', 'public');
        $data['image'] = 'storage/'.$path;

        if ($oldImage && Str::startsWith($oldImage, 'storage/')) {
            Storage::disk('public')->delete(Str::after($oldImage, 'storage/'));
        }

        return $data;
    }
}

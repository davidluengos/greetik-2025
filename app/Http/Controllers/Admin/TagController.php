<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::query()->orderByDesc('repetitions')->orderBy('name')->paginate(30);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        $tag = new Tag(['repetitions' => 0]);

        return view('admin.tags.create', compact('tag'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('status', 'Tag creada correctamente.');
    }

    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $this->validatedData($request, $tag->id);
        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('status', 'Tag actualizada correctamente.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('status', 'Tag eliminada.');
    }

    private function validatedData(Request $request, ?int $tagId = null): array
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tag', 'name')->ignore($tagId),
            ],
            'repetitions' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['name'] = Str::lower(trim($data['name']));
        $data['repetitions'] = $data['repetitions'] ?? 0;
        $data['project'] = 0;

        return $data;
    }
}

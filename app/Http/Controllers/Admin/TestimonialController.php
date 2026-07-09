<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Testimonial::class, 'testimonial');
    }

    public function index()
    {
        $testimonials = Testimonial::orderBy('menu_order')->orderBy('author')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $testimonial = new Testimonial();

        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function store(Request $request)
    {
        Testimonial::create($this->validatedData($request));

        return redirect()->route('admin.testimonials.index')->with('status', 'Opinion creada correctamente.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validatedData($request));

        return redirect()->route('admin.testimonials.index')->with('status', 'Opinion actualizada correctamente.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('status', 'Opinion eliminada.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'author' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'photo' => ['nullable', 'string', 'max:255'],
            'menu_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['menu_order'] = $data['menu_order'] ?? 0;

        return $data;
    }
}

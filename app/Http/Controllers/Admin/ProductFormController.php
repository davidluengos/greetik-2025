<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductForm;
use Illuminate\Http\Request;

class ProductFormController extends Controller
{
    public function index()
    {
        $forms = ProductForm::query()
            ->orderBy('name')
            ->paginate(20);

        return view('admin.product-forms.index', compact('forms'));
    }

    public function create()
    {
        $form = new ProductForm();

        return view('admin.product-forms.create', compact('form'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        ProductForm::create($data);

        return redirect()->route('admin.product-forms.index')->with('status', 'Formulario creado correctamente.');
    }

    public function show(ProductForm $product_form)
    {
        return view('admin.product-forms.show', ['form' => $product_form]);
    }

    public function edit(ProductForm $product_form)
    {
        return view('admin.product-forms.edit', ['form' => $product_form]);
    }

    public function update(Request $request, ProductForm $product_form)
    {
        $data = $this->validatedData($request);
        $product_form->update($data);

        return redirect()->route('admin.product-forms.index')->with('status', 'Formulario actualizado correctamente.');
    }

    public function destroy(ProductForm $product_form)
    {
        $product_form->delete();

        return redirect()->route('admin.product-forms.index')->with('status', 'Formulario eliminado.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'intro' => ['nullable', 'string'],
            'action_url' => ['nullable', 'string', 'max:500'],
            'button_label' => ['nullable', 'string', 'max:120'],
            'fields' => ['nullable', 'json'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['action_url'] = $data['action_url'] ?: '/contacto';
        $data['button_label'] = $data['button_label'] ?: 'Enviar';
        $decoded = isset($data['fields']) ? json_decode($data['fields'], true) : null;
        $data['fields'] = is_array($decoded) && $decoded !== [] ? $decoded : self::defaultFields();

        return $data;
    }

    public static function defaultFields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'required' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ['name' => 'phone', 'label' => 'Telefono', 'type' => 'text', 'required' => false],
            ['name' => 'message', 'label' => 'Mensaje', 'type' => 'textarea', 'required' => true],
        ];
    }
}

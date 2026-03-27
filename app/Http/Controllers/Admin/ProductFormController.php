<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductFormRequest;
use App\Http\Requests\Admin\UpdateProductFormRequest;
use App\Models\ProductForm;
use App\Support\ProductForms\DefaultProductFormFields;

class ProductFormController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProductForm::class, 'product_form');
    }

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

    public function store(StoreProductFormRequest $request)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
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

    public function update(UpdateProductFormRequest $request, ProductForm $product_form)
    {
        $data = $this->validatedData($request->validated(), $request->boolean('is_active'));
        $product_form->update($data);

        return redirect()->route('admin.product-forms.index')->with('status', 'Formulario actualizado correctamente.');
    }

    public function destroy(ProductForm $product_form)
    {
        $product_form->delete();

        return redirect()->route('admin.product-forms.index')->with('status', 'Formulario eliminado.');
    }

    private function validatedData(array $data, bool $isActive): array
    {
        $data['is_active'] = $isActive;
        $data['action_url'] = $data['action_url'] ?: '/contacto';
        $data['button_label'] = $data['button_label'] ?: 'Enviar';
        $decoded = isset($data['fields']) ? json_decode($data['fields'], true) : null;
        $data['fields'] = is_array($decoded) && $decoded !== [] ? $decoded : DefaultProductFormFields::get();

        return $data;
    }
}

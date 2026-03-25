@extends('admin.layouts.app')

@section('title', 'Formulario #' . $form->id)

@section('content')
    <h1 class="h3 mb-4 text-gray-800">{{ $form->name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Titulo:</strong> {{ $form->title }}</p>
            @if ($form->intro)
                <p><strong>Intro:</strong> {{ $form->intro }}</p>
            @endif
            <p><strong>URL envio:</strong> {{ $form->action_url }}</p>
            <p><strong>Boton:</strong> {{ $form->button_label }}</p>
            <p><strong>Activo:</strong> {{ $form->is_active ? 'Si' : 'No' }}</p>
            <hr>
            <pre class="bg-light p-3 small">{{ json_encode($form->fields, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>

    <a href="{{ route('admin.product-forms.edit', $form) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('admin.product-forms.index') }}" class="btn btn-secondary">Volver</a>
@endsection

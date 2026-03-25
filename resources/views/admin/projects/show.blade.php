@extends('admin.layouts.app')

@section('title', 'Detalle Producto - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Producto #{{ $project->id }}</h1>
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Titulo:</strong> {{ $project->title }}</p>
            <p><strong>Slug:</strong> {{ $project->slug }}</p>
            <p><strong>Web:</strong> {{ $project->website_url }}</p>
            <p><strong>Formulario:</strong>
                @if ($project->productForm)
                    <a href="{{ route('admin.product-forms.edit', $project->productForm) }}">{{ $project->productForm->name }}</a>
                @else
                    <span class="text-muted">Ninguno</span>
                @endif
            </p>
            <p><strong>Tabla de precios:</strong>
                @if ($project->pricingTable)
                    <a href="{{ route('admin.pricing-tables.edit', $project->pricingTable) }}">{{ $project->pricingTable->name }}</a>
                @else
                    <span class="text-muted">Ninguna</span>
                @endif
            </p>
            <p><strong>Extracto:</strong> {{ $project->excerpt }}</p>
            <p><strong>Contenido:</strong><br>{!! nl2br(e($project->body)) !!}</p>
            <p><strong>Activo:</strong> {{ $project->is_active ? 'Si' : 'No' }}</p>
            <p><strong>Orden:</strong> {{ $project->menu_order }}</p>
            <p><strong>Publicacion:</strong> {{ $project->published_at }}</p>
        </div>
    </div>
@endsection

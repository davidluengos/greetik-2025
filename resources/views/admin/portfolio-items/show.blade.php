@extends('admin.layouts.app')

@section('title', 'Detalle Portfolio - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Portfolio #{{ $portfolioItem->id }}</h1>
        <a href="{{ route('admin.portfolio-items.edit', $portfolioItem) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Titulo:</strong> {{ $portfolioItem->title }}</p>
            <p><strong>Slug:</strong> {{ $portfolioItem->slug }}</p>
            <p><strong>Categoria:</strong> {{ $portfolioItem->category }}</p>
            <p><strong>Cliente:</strong> {{ $portfolioItem->client }}</p>
            <p><strong>Fecha fin:</strong> {{ $portfolioItem->completed_at }}</p>
            <p><strong>Extracto:</strong> {{ $portfolioItem->excerpt }}</p>
            <p><strong>Contenido:</strong><br>{!! nl2br(e($portfolioItem->body)) !!}</p>
            <p><strong>Activo:</strong> {{ $portfolioItem->is_active ? 'Si' : 'No' }}</p>
            <p><strong>Orden:</strong> {{ $portfolioItem->menu_order }}</p>
            <p><strong>Publicacion:</strong> {{ $portfolioItem->published_at }}</p>
        </div>
    </div>
@endsection

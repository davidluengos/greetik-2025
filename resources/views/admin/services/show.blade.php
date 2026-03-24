@extends('admin.layouts.app')

@section('title', 'Detalle Servicio - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Servicio #{{ $service->id }}</h1>
        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Titulo:</strong> {{ $service->title }}</p>
            <p><strong>Slug:</strong> {{ $service->slug }}</p>
            <p><strong>Extracto:</strong> {{ $service->excerpt }}</p>
            <p><strong>Contenido:</strong><br>{!! nl2br(e($service->body)) !!}</p>
            <p><strong>Activo:</strong> {{ $service->is_active ? 'Si' : 'No' }}</p>
            <p><strong>Orden:</strong> {{ $service->menu_order }}</p>
            <p><strong>Publicacion:</strong> {{ $service->published_at }}</p>
            <p><strong>Extra:</strong> {{ $service->extra ? json_encode($service->extra) : '-' }}</p>
        </div>
    </div>
@endsection

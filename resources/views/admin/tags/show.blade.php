@extends('admin.layouts.app')

@section('title', 'Detalle Tag - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tag #{{ $tag->id }}</h1>
        <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $tag->name }}</p>
            <p><strong>Repeticiones:</strong> {{ $tag->repetitions }}</p>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Detalle Post - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Post #{{ $post->id }}</h1>
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Titulo:</strong> {{ $post->title }}</p>
            <p class="mb-2"><strong>Tags:</strong></p>
            <p>
                @forelse ($post->tags_array as $tag)
                    <span class="badge badge-pill badge-info mr-1 mb-1">{{ $tag }}</span>
                @empty
                    <span class="text-muted">Sin tags</span>
                @endforelse
            </p>
            <p><strong>Meta title:</strong> {{ $post->metatitle }}</p>
            <p><strong>Meta description:</strong> {{ $post->metadescription }}</p>
            <p><strong>Publicacion:</strong> {{ $post->publishdate }}</p>
            <p><strong>Fin:</strong> {{ $post->enddate }}</p>
            <p><strong>Contenido:</strong></p>
            <div class="border rounded p-3 bg-white">
                {!! $post->body !!}
            </div>
            <p><strong>Extra:</strong><br>{!! nl2br(e((string) $post->extra)) !!}</p>
        </div>
    </div>
@endsection

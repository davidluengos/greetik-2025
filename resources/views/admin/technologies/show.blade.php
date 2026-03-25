@extends('admin.layouts.app')

@section('title', 'Ver tecnologia')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tecnologia #{{ $technology->id }}</h1>
        <div>
            <a href="{{ route('admin.technologies.edit', $technology) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-pen"></i> Editar
            </a>
            <a href="{{ route('admin.technologies.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Titulo</dt>
                <dd class="col-sm-9">{{ $technology->title }}</dd>

                <dt class="col-sm-3">Slug</dt>
                <dd class="col-sm-9">{{ $technology->slug }}</dd>

                <dt class="col-sm-3">Imagen</dt>
                <dd class="col-sm-9">{{ $technology->image ?: '-' }}</dd>

                <dt class="col-sm-3">Icono</dt>
                <dd class="col-sm-9">{{ $technology->icon ?: '-' }}</dd>

                <dt class="col-sm-3">Badge</dt>
                <dd class="col-sm-9">{{ $technology->badge ?: '-' }}</dd>

                <dt class="col-sm-3">Orden</dt>
                <dd class="col-sm-9">{{ $technology->menu_order }}</dd>

                <dt class="col-sm-3">Activa</dt>
                <dd class="col-sm-9">{{ $technology->is_active ? 'Si' : 'No' }}</dd>

                <dt class="col-sm-3">Extra</dt>
                <dd class="col-sm-9">
                    @if ($technology->extra)
                        <pre class="mb-0">{{ json_encode($technology->extra, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @else
                        -
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection

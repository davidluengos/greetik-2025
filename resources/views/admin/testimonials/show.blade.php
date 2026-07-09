@extends('admin.layouts.app')

@section('title', 'Opinion - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $testimonial->author }}</h1>
        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Autor</dt>
                <dd class="col-sm-9">{{ $testimonial->author }}</dd>

                <dt class="col-sm-3">Cargo / empresa</dt>
                <dd class="col-sm-9">{{ $testimonial->role ?: '-' }}</dd>

                <dt class="col-sm-3">Opinion</dt>
                <dd class="col-sm-9">{{ $testimonial->quote }}</dd>

                <dt class="col-sm-3">Foto</dt>
                <dd class="col-sm-9">
                    @if ($testimonial->photo)
                        <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->author }}" class="img-thumbnail" style="max-height:120px">
                    @else
                        -
                    @endif
                </dd>

                <dt class="col-sm-3">Orden</dt>
                <dd class="col-sm-9">{{ $testimonial->menu_order }}</dd>

                <dt class="col-sm-3">Activo</dt>
                <dd class="col-sm-9">{{ $testimonial->is_active ? 'Si' : 'No' }}</dd>
            </dl>
        </div>
    </div>

    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Volver</a>
@endsection

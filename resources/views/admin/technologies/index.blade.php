@extends('admin.layouts.app')

@section('title', 'Tecnologias')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tecnologias</h1>
        <a href="{{ route('admin.technologies.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nueva tecnologia
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titulo</th>
                            <th>Slug</th>
                            <th>Orden</th>
                            <th>Activa</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($technologies as $technology)
                            <tr>
                                <td>{{ $technology->id }}</td>
                                <td>{{ $technology->title }}</td>
                                <td>{{ $technology->slug }}</td>
                                <td>{{ $technology->menu_order }}</td>
                                <td>{{ $technology->is_active ? 'Si' : 'No' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.technologies.show', $technology) }}" class="btn btn-info btn-sm d-inline-block m-0">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.technologies.edit', $technology) }}" class="btn btn-warning btn-sm d-inline-block m-0">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.technologies.destroy', $technology) }}" method="POST"
                                        class="d-inline-block m-0" onsubmit="return confirm('¿Eliminar tecnologia?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay tecnologias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $technologies->links() }}
@endsection

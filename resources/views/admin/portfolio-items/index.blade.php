@extends('admin.layouts.app')

@section('title', 'Portfolio - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="h3 mb-0 text-gray-800">Portfolio</h1>
        <div class="d-flex flex-wrap gap-2">
            @if ($portfolioIntroPage)
                <a href="{{ route('admin.site-pages.edit', $portfolioIntroPage) }}" class="btn btn-outline-secondary btn-sm">Texto de bienvenida</a>
            @endif
            <a href="{{ route('admin.portfolio-items.create') }}" class="btn btn-primary btn-sm">Nuevo elemento</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Slug</th>
                        <th>Categoria</th>
                        <th>Activo</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($portfolioItems as $portfolioItem)
                        <tr>
                            <td>{{ $portfolioItem->id }}</td>
                            <td>{{ $portfolioItem->title }}</td>
                            <td>{{ $portfolioItem->slug }}</td>
                            <td>{{ $portfolioItem->category }}</td>
                            <td>{{ $portfolioItem->is_active ? 'Si' : 'No' }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.portfolio-items.show', $portfolioItem) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.portfolio-items.edit', $portfolioItem) }}" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.portfolio-items.destroy', $portfolioItem) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar elemento?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Sin registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $portfolioItems->links() }}
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Tags - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tags</h1>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">Nueva tag</a>
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
                        <th>Nombre</th>
                        <th>Repeticiones</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->repetitions }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.tags.show', $tag) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.tags.edit', $tag) }}" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar tag?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Sin registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $tags->links() }}
        </div>
    </div>
@endsection

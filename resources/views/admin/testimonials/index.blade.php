@extends('admin.layouts.app')

@section('title', 'Opiniones - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Opiniones de clientes</h1>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">Nueva opinion</a>
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
                        <th>Autor</th>
                        <th>Cargo / empresa</th>
                        <th>Orden</th>
                        <th>Activo</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $testimonial)
                        <tr>
                            <td>{{ $testimonial->id }}</td>
                            <td>{{ $testimonial->author }}</td>
                            <td>{{ $testimonial->role }}</td>
                            <td>{{ $testimonial->menu_order }}</td>
                            <td>{{ $testimonial->is_active ? 'Si' : 'No' }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.testimonials.show', $testimonial) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.testimonials.edit', $testimonial) }}" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar opinion?')">
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
            {{ $testimonials->links() }}
        </div>
    </div>
@endsection

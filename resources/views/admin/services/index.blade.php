@extends('admin.layouts.app')

@section('title', 'Servicios - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Servicios</h1>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">Nuevo servicio</a>
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
                        <th>Orden</th>
                        <th>Orden home</th>
                        <th>Activo</th>
                        <th>En home</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->slug }}</td>
                            <td>{{ $service->menu_order }}</td>
                            <td>{{ $service->home_order ?? 0 }}</td>
                            <td>{{ $service->is_active ? 'Si' : 'No' }}</td>
                            <td>{{ $service->show_on_home ? 'Si' : 'No' }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.services.show', $service) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.services.edit', $service) }}" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar servicio?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Sin registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $services->links() }}
        </div>
    </div>
@endsection

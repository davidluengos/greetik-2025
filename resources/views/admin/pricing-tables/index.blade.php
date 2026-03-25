@extends('admin.layouts.app')

@section('title', 'Tablas de precios')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tablas de precios</h1>
        <a href="{{ route('admin.pricing-tables.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nueva tabla
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
                            <th>Nombre interno</th>
                            <th>Titulo (front)</th>
                            <th>Activa</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pricingTables as $table)
                            <tr>
                                <td>{{ $table->id }}</td>
                                <td>{{ $table->name }}</td>
                                <td>{{ $table->title }}</td>
                                <td>{{ $table->is_active ? 'Si' : 'No' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.pricing-tables.show', $table) }}" class="btn btn-info btn-sm d-inline-block m-0">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pricing-tables.edit', $table) }}" class="btn btn-warning btn-sm d-inline-block m-0">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.pricing-tables.destroy', $table) }}" method="POST"
                                        class="d-inline-block m-0" onsubmit="return confirm('¿Eliminar tabla de precios?')">
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
                                <td colspan="5" class="text-center text-muted">No hay tablas de precios.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $pricingTables->links() }}
@endsection

@extends('admin.layouts.app')

@section('title', 'Mensajes - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mensajes de formularios</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Formulario</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr class="{{ $message->read_at ? '' : 'font-weight-bold' }}">
                            <td class="text-nowrap">
                                @unless ($message->read_at)
                                    <span class="badge badge-danger">Nuevo</span>
                                @endunless
                                {{ $message->created_at?->format('d/m/Y H:i') }}
                            </td>
                            <td>{{ $message->name ?: '-' }}</td>
                            <td>{{ $message->email ?: '-' }}</td>
                            <td>{{ $message->phone ?: '-' }}</td>
                            <td>{{ $message->form_name ?: '-' }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.contact-messages.show', $message) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar mensaje?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Sin mensajes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $messages->links() }}
        </div>
    </div>
@endsection

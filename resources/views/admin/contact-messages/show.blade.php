@extends('admin.layouts.app')

@section('title', 'Mensaje - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mensaje de {{ $message->name ?: 'contacto' }}</h1>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary btn-sm">Volver</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header">Datos enviados</div>
        <div class="card-body">
            <dl class="row mb-0">
                @forelse (($message->data ?? []) as $label => $value)
                    <dt class="col-sm-3">{{ $label }}</dt>
                    <dd class="col-sm-9" style="white-space: pre-wrap;">{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</dd>
                @empty
                    <dd class="col-12 mb-0">Sin datos.</dd>
                @endforelse
            </dl>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">Metadatos</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Recibido</dt>
                <dd class="col-sm-9">{{ $message->created_at?->format('d/m/Y H:i:s') }}</dd>

                <dt class="col-sm-3">Formulario</dt>
                <dd class="col-sm-9">{{ $message->form_name ?: '-' }}</dd>

                <dt class="col-sm-3">Enviado desde</dt>
                <dd class="col-sm-9">
                    @if ($message->source_url)
                        <a href="{{ $message->source_url }}" target="_blank" rel="noopener">{{ $message->source_url }}</a>
                    @else
                        -
                    @endif
                </dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">
                    @if ($message->email)
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                    @else
                        -
                    @endif
                </dd>

                <dt class="col-sm-3">IP</dt>
                <dd class="col-sm-9">{{ $message->ip ?: '-' }}</dd>

                <dt class="col-sm-3">Navegador</dt>
                <dd class="col-sm-9"><small class="text-muted">{{ $message->user_agent ?: '-' }}</small></dd>
            </dl>
        </div>
    </div>

    <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline-block">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" onclick="return confirm('Eliminar mensaje?')">Eliminar</button>
    </form>
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">Volver</a>
@endsection

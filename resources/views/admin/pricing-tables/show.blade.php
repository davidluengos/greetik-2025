@extends('admin.layouts.app')

@section('title', 'Tabla de precios #' . $pricingTable->id)

@section('content')
    <h1 class="h3 mb-0 text-gray-800">{{ $pricingTable->name }}</h1>
    <p class="text-muted mb-4">{{ $pricingTable->title }} @if ($pricingTable->subtitle) — {{ $pricingTable->subtitle }} @endif</p>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Activa:</strong> {{ $pricingTable->is_active ? 'Si' : 'No' }}</p>
            <hr>
            <pre class="bg-light p-3 small">{{ json_encode($pricingTable->plans, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>

    <a href="{{ route('admin.pricing-tables.edit', $pricingTable) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('admin.pricing-tables.index') }}" class="btn btn-secondary">Volver</a>
@endsection

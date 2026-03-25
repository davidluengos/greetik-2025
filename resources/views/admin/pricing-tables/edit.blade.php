@extends('admin.layouts.app')

@section('title', 'Editar tabla de precios')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar tabla de precios</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pricing-tables.update', $pricingTable) }}" method="POST">
                @method('PUT')
                @include('admin.pricing-tables._form')
            </form>
        </div>
    </div>
@endsection

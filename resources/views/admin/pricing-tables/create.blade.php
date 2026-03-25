@extends('admin.layouts.app')

@section('title', 'Nueva tabla de precios')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nueva tabla de precios</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pricing-tables.store') }}" method="POST">
                @include('admin.pricing-tables._form')
            </form>
        </div>
    </div>
@endsection

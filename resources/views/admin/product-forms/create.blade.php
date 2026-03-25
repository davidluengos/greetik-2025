@extends('admin.layouts.app')

@section('title', 'Nuevo formulario')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nuevo formulario</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.product-forms.store') }}" method="POST">
                @include('admin.product-forms._form')
            </form>
        </div>
    </div>
@endsection

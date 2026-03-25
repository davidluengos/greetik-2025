@extends('admin.layouts.app')

@section('title', 'Editar formulario')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar formulario</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.product-forms.update', $form) }}" method="POST">
                @method('PUT')
                @include('admin.product-forms._form')
            </form>
        </div>
    </div>
@endsection

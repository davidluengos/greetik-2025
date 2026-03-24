@extends('admin.layouts.app')

@section('title', 'Editar Producto - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar producto</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST">
                @method('PUT')
                @include('admin.projects._form')
            </form>
        </div>
    </div>
@endsection

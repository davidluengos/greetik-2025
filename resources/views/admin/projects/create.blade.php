@extends('admin.layouts.app')

@section('title', 'Nuevo Producto - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nuevo producto</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.projects.store') }}" method="POST">
                @include('admin.projects._form')
            </form>
        </div>
    </div>
@endsection

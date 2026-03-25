@extends('admin.layouts.app')

@section('title', 'Editar tecnologia')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar tecnologia</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.technologies.update', $technology) }}" method="POST">
                @method('PUT')
                @include('admin.technologies._form')
            </form>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Editar Portfolio - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar elemento de portfolio</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.portfolio-items.update', $portfolioItem) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.portfolio-items._form')
            </form>
        </div>
    </div>
@endsection

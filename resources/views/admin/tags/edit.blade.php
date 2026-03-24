@extends('admin.layouts.app')

@section('title', 'Editar Tag - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar tag</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                @method('PUT')
                @include('admin.tags._form')
            </form>
        </div>
    </div>
@endsection

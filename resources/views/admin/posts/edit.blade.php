@extends('admin.layouts.app')

@section('title', 'Editar Post - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar post</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST">
                @method('PUT')
                @include('admin.posts._form')
            </form>
        </div>
    </div>
@endsection

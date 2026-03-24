@extends('admin.layouts.app')

@section('title', 'Nuevo Post - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nuevo post</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST">
                @include('admin.posts._form')
            </form>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Editar pagina')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar: {{ $page->title }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.site-pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.site-pages._form')
            </form>
        </div>
    </div>
@endsection

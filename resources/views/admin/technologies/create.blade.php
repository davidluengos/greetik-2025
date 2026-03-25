@extends('admin.layouts.app')

@section('title', 'Nueva tecnologia')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nueva tecnologia</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.technologies.store') }}" method="POST">
                @include('admin.technologies._form')
            </form>
        </div>
    </div>
@endsection

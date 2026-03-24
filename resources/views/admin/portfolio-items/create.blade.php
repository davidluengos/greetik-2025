@extends('admin.layouts.app')

@section('title', 'Nuevo Portfolio - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nuevo elemento de portfolio</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.portfolio-items.store') }}" method="POST">
                @include('admin.portfolio-items._form')
            </form>
        </div>
    </div>
@endsection

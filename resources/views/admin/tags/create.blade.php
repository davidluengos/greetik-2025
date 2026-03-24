@extends('admin.layouts.app')

@section('title', 'Nueva Tag - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nueva tag</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @include('admin.tags._form')
            </form>
        </div>
    </div>
@endsection

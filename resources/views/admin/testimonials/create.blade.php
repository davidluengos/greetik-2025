@extends('admin.layouts.app')

@section('title', 'Nueva opinion - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Nueva opinion</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.testimonials.store') }}" method="POST">
                @include('admin.testimonials._form')
            </form>
        </div>
    </div>
@endsection

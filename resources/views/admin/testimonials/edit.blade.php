@extends('admin.layouts.app')

@section('title', 'Editar opinion - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar opinion</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
                @method('PUT')
                @include('admin.testimonials._form')
            </form>
        </div>
    </div>
@endsection

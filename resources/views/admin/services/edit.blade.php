@extends('admin.layouts.app')

@section('title', 'Editar Servicio - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Editar servicio</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.services.update', $service) }}" method="POST">
                @method('PUT')
                @include('admin.services._form')
            </form>
        </div>
    </div>
@endsection

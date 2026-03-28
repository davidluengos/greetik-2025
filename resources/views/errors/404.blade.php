@extends('front.layouts.app')

@section('title', '404 | Página no encontrada')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1>404</h1>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">404</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="gray-bg">
        <div class="fof">
            <div class="container error-inner wow flipInX">
                <h1>404 — Página no encontrada</h1>
                <p class="text-center">La página que buscas no existe o ha ocurrido un error.</p>
                <a class="btn btn-info" href="{{ route('home') }}">Volver al inicio</a>
            </div>
        </div>
    </div>
@endsection

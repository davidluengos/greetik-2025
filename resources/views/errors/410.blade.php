@extends('front.layouts.app')

@section('title', \App\Support\SiteBranding::pageTitle('Página retirada'))

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <p class="h1">410</p>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">Contenido retirado</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="gray-bg">
        <div class="fof">
            <div class="container error-inner wow flipInX">
                <h1>Esta página ya no existe</h1>
                <p class="text-center">El contenido que buscabas fue retirado o migrado a otra ubicación. Explora los productos, el blog o vuelve al inicio.</p>
                <p class="text-center">
                    <a class="btn btn-info" href="{{ route('home') }}">Volver al inicio</a>
                    <a class="btn btn-default" href="{{ route('posts.index') }}">Ver blog</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@extends('front.layouts.app')

@section('title', $page->meta_title ?: 'Greetik | ' . $page->title)

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <h1>{{ $page->title }}</h1>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">{{ $page->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container legal-page-body py-5">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if (!empty($page->body))
                    {!! $page->body !!}
                @endif
            </div>
        </div>
    </div>
@endsection

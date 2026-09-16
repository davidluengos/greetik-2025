@extends('front.layouts.app')

@php
    $pageTitle = \App\Support\SiteBranding::pageTitle($page->title, $page->meta_title);
    $seoDescription = filled($page->meta_description)
        ? $page->meta_description
        : \App\Support\SiteBranding::defaultDescription();
@endphp

@section('title', $pageTitle)
@section('meta_description', $seoDescription)
@section('og_title', $pageTitle)
@section('og_description', $seoDescription)
@section('twitter_title', $pageTitle)
@section('twitter_description', $seoDescription)

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <p class="h1">{{ $page->title }}</p>
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

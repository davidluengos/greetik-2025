@extends('front.layouts.app')

@php
    $canonical = route('automatiza.sector', ['slug' => $slug]);
    $seoTitle = $page['meta_title'] ?? $page['title'];
    $seoDescription = $page['meta_description'] ?? '';
    $ogImage = asset('front/img/parallax-slider/images/greetik-soluciones.png');
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('canonical', $canonical)
@section('og_type', 'article')
@section('og_title', $seoTitle)
@section('og_description', $seoDescription)
@section('og_url', $canonical)
@section('og_image', $ogImage)

@push('styles')
    <link href="{{ asset('front/css/automatiza.css') }}?v=1" rel="stylesheet">
@endpush

@section('content')
    <div class="aut-scope">
        <section class="aut-hero">
            <div class="aut-container">
                <span class="aut-eyebrow">Greetik Automatiza · Sector</span>
                <h1 class="aut-h1">{{ $page['title'] }}</h1>
                @if (! empty($page['intro']))
                    <p class="aut-lead">{{ $page['intro'] }}</p>
                @endif
                <div class="aut-cta-row">
                    <a class="aut-btn aut-btn-primary" href="{{ route('automatiza.wizard') }}">
                        Analizar mi empresa <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a class="aut-btn aut-btn-secondary" href="{{ route('automatiza.landing') }}">Cómo funciona</a>
                </div>
            </div>
        </section>

        @if (! empty($page['problems']))
            <section class="aut-section aut-section-alt">
                <div class="aut-container">
                    <h2 class="aut-section-title" style="text-align:center;">Problemas habituales del sector</h2>
                    <div class="aut-card" style="max-width:820px; margin: 0 auto;">
                        <ul class="aut-list">
                            @foreach ($page['problems'] as $problem)
                                <li>{{ $problem }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endif

        @if (! empty($page['processes']))
            <section class="aut-section">
                <div class="aut-container">
                    <h2 class="aut-section-title" style="text-align:center;">Procesos que se pueden automatizar</h2>
                    <div class="aut-grid aut-grid-2">
                        @foreach ($page['processes'] as $process)
                            <div class="aut-card">
                                <div class="aut-icon"><i class="fa fa-cogs"></i></div>
                                <p style="color:#0f172a; margin:0;">{{ $process }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if (! empty($page['example']))
            <section class="aut-section aut-section-alt">
                <div class="aut-container" style="max-width:820px;">
                    <h2 class="aut-section-title" style="text-align:center;">Ejemplo de ahorro potencial</h2>
                    <div class="aut-card">
                        <p style="margin:0; font-size:17px;">{{ $page['example'] }}</p>
                    </div>
                </div>
            </section>
        @endif

        <section class="aut-section">
            <div class="aut-container" style="text-align:center;">
                <h2 class="aut-section-title">Descubre tu potencial exacto</h2>
                <p class="aut-section-lead">
                    Responde el cuestionario y obtén un informe personalizado con las horas y euros que podrías
                    ahorrar en tu empresa.
                </p>
                <a class="aut-btn aut-btn-primary" href="{{ route('automatiza.wizard') }}">
                    Analizar mi empresa
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </div>
@endsection

@extends('front.layouts.app')

@php
    $seoTitle = 'Automatizar tu empresa: análisis gratuito | Greetik';
    $seoDescription = 'Descubre en 2-3 minutos qué procesos de tu empresa puedes automatizar, cuánto tiempo y dinero podrías ahorrar y por dónde empezar. Gratis y sin conocimientos técnicos.';
    $canonical = route('automatiza.landing');
    $ogImage = asset('front/img/parallax-slider/images/greetik-soluciones.png');
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('canonical', $canonical)
@section('og_title', $seoTitle)
@section('og_description', $seoDescription)
@section('og_url', $canonical)
@section('og_image', $ogImage)
@section('twitter_title', $seoTitle)
@section('twitter_description', $seoDescription)
@section('twitter_image', $ogImage)

@push('styles')
    <link href="{{ asset('front/css/automatiza.css') }}?v=1" rel="stylesheet">
@endpush

@section('content')
    <div class="aut-scope">
        <section class="aut-hero">
            <div class="aut-container">
                <span class="aut-eyebrow">Greetik Automatiza · Herramienta gratuita</span>
                <h1 class="aut-h1">¿Cuánto tiempo y dinero podrías ahorrar automatizando tu empresa?</h1>
                <p class="aut-lead">
                    Responde unas preguntas sobre cómo trabajas actualmente y descubre qué procesos podrías
                    automatizar, cuánto tiempo podrías ahorrar y por dónde empezar.
                </p>
                <div class="aut-cta-row">
                    <a class="aut-btn aut-btn-primary" href="{{ route('automatiza.wizard') }}">
                        Analizar mi empresa
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a class="aut-btn aut-btn-secondary" href="#como-funciona">Cómo funciona</a>
                </div>
                <div class="aut-badges">
                    <span><i class="fa fa-check-circle"></i> 100 % gratis</span>
                    <span><i class="fa fa-check-circle"></i> Sin registro obligatorio</span>
                    <span><i class="fa fa-check-circle"></i> 2-3 minutos</span>
                    <span><i class="fa fa-check-circle"></i> Sin conocimientos técnicos</span>
                </div>
            </div>
        </section>

        <section class="aut-section aut-section-alt" id="como-funciona">
            <div class="aut-container">
                <h2 class="aut-section-title" style="text-align:center;">Cómo funciona</h2>
                <p class="aut-section-lead">
                    Un cuestionario corto y visual analiza cómo opera tu negocio. En base a tus respuestas obtienes
                    un informe personalizado con horas, dinero, procesos prioritarios y tipo de solución recomendada.
                </p>
                <div class="aut-grid aut-grid-3">
                    <div class="aut-card">
                        <div class="aut-icon"><i class="fa fa-list"></i></div>
                        <h3>1. Responde 11 preguntas</h3>
                        <p>Sobre tu sector, tamaño, herramientas actuales y dónde perdéis más tiempo. Sin tecnicismos.</p>
                    </div>
                    <div class="aut-card">
                        <div class="aut-icon"><i class="fa fa-cogs"></i></div>
                        <h3>2. El motor analiza</h3>
                        <p>Calculamos el nivel de automatización, las horas ahorrables y priorizamos 3 procesos concretos.</p>
                    </div>
                    <div class="aut-card">
                        <div class="aut-icon"><i class="fa fa-line-chart"></i></div>
                        <h3>3. Recibes tu informe</h3>
                        <p>Con ahorro anual estimado, tipo de solución y rango de inversión. Sin compromiso.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="aut-section">
            <div class="aut-container">
                <h2 class="aut-section-title" style="text-align:center;">Qué vas a saber al terminar</h2>
                <div class="aut-grid aut-grid-2">
                    <div class="aut-card">
                        <h3>Tu nivel de automatización (0-100)</h3>
                        <p>Un único número que resume el potencial de mejora, con contexto para interpretarlo.</p>
                    </div>
                    <div class="aut-card">
                        <h3>Horas y euros que podrías ahorrar</h3>
                        <p>Estimación conservadora en semanas, meses y años. Preferimos quedarnos cortos a exagerar.</p>
                    </div>
                    <div class="aut-card">
                        <h3>Los 3 procesos por los que empezaría</h3>
                        <p>Priorizados según tus respuestas, con el motivo, el potencial y la solución típica.</p>
                    </div>
                    <div class="aut-card">
                        <h3>Tipo de solución e inversión orientativa</h3>
                        <p>Desde «mejorar procesos» hasta «aplicación web completa», con rango de inversión de mercado.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="aut-section aut-section-alt">
            <div class="aut-container">
                <h2 class="aut-section-title" style="text-align:center;">Diseñada para empresas pequeñas y autónomos</h2>
                <p class="aut-section-lead">
                    Trabajamos con negocios que no tienen departamento de IT. La herramienta pone en palabras claras
                    lo que otros llaman «digitalización» o «transformación digital».
                </p>
                <div class="aut-grid aut-grid-3">
                    <div class="aut-card">
                        <h3>Construcción y mantenimiento</h3>
                        <p>Partes de trabajo, albaranes, presupuestos y organización de obras.</p>
                    </div>
                    <div class="aut-card">
                        <h3>Servicios profesionales</h3>
                        <p>Gestión de clientes, seguimiento comercial y generación de documentos.</p>
                    </div>
                    <div class="aut-card">
                        <h3>Gimnasios y centros deportivos</h3>
                        <p>Reservas, cobros recurrentes y comunicación con socios.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="aut-section">
            <div class="aut-container" style="max-width: 820px;">
                <h2 class="aut-section-title" style="text-align:center;">Preguntas frecuentes</h2>
                <p class="aut-section-lead">Lo que nos preguntan más a menudo antes de usar la herramienta.</p>
                @foreach ($faqs as $faq)
                    <details class="aut-faq">
                        <summary>{{ $faq['q'] }}</summary>
                        <p>{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        <section class="aut-section aut-section-alt">
            <div class="aut-container" style="text-align:center;">
                <h2 class="aut-section-title">Empieza tu análisis ahora</h2>
                <p class="aut-section-lead">Sin registro. Sin compromiso. En 2-3 minutos tienes tu informe.</p>
                <a class="aut-btn aut-btn-primary" href="{{ route('automatiza.wizard') }}">
                    Analizar mi empresa
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </div>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebApplication',
                'name' => 'Greetik Automatiza',
                'url' => $canonical,
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'Web',
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'EUR'],
                'description' => $seoDescription,
            ],
            [
                '@type' => 'FAQPage',
                'mainEntity' => array_map(static fn ($f) => [
                    '@type' => 'Question',
                    'name' => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ], $faqs),
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

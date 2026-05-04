@extends('front.layouts.app')

@section('title', 'Greetik | ' . $project->title)

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <h1>{{ $project->title }}</h1>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">Producto</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        $formModel = $project->productForm;
        $pricingModel = $project->pricingTable;
    @endphp

    @if ($pricingModel && $pricingModel->is_active && !empty($pricingModel->plans) && is_array($pricingModel->plans))
        <div class="gray-bg price-container py-5">
            <div class="section first">
                <div class="container">
                    <div class="page-header">
                        <h1 class="text-center">
                            <span class="wow flipInX">{{ $pricingModel->title }}</span>
                            @if (!empty($pricingModel->subtitle))
                                <small class="wow flipInX">{{ $pricingModel->subtitle }}</small>
                            @endif
                        </h1>
                    </div>
                    <div class="row product-offer-layout">
                        <div class="col-md-8 price-two-container product-plans-container">
                            <div class="product-plans-grid">
                            @foreach ($pricingModel->plans as $plan)
                                @php
                                    $planFeatures = collect($plan['features'] ?? [])->filter(fn ($item) => filled($item))->values();
                                    $startsFrom = $plan['price'] ?? '-';

                                    $infoRows = $planFeatures->filter(function ($feature) {
                                        $normalized = mb_strtolower(trim((string) $feature), 'UTF-8');
                                        return str_contains($normalized, 'activación')
                                            || str_contains($normalized, 'permanencia')
                                            || str_contains($normalized, 'responsive')
                                            || str_contains($normalized, 'ssl')
                                            || str_contains($normalized, 'prueba gratuita')
                                            || str_contains($normalized, 'sin iva');
                                    })->values();

                                    $featureRows = $planFeatures->reject(function ($feature) {
                                        $normalized = mb_strtolower(trim((string) $feature), 'UTF-8');
                                        return str_contains($normalized, 'activación')
                                            || str_contains($normalized, 'permanencia')
                                            || str_contains($normalized, 'responsive')
                                            || str_contains($normalized, 'ssl')
                                            || str_contains($normalized, 'prueba gratuita')
                                            || str_contains($normalized, 'sin iva')
                                            || $normalized === 'características';
                                    })->values();
                                @endphp
                                <div class="product-plan-col">
                                    <div class="pricing-table-two product-feature-card {{ !empty($plan['highlighted']) ? 'highlighted' : '' }} wow fadeInUp">
                                        <div class="inner">
                                            <div class="title">{{ $plan['name'] ?? 'Plan' }}</div>
                                            <div class="product-feature-price-wrap">
                                                <p class="product-feature-price-label">Desde</p>
                                                <p class="product-feature-price">{{ $startsFrom }}</p>
                                            </div>
                                            @if (!empty($plan['description']))
                                                <p class="desc">{{ $plan['description'] }}</p>
                                            @endif
                                            @if ($infoRows->isNotEmpty())
                                                <ul class="product-plan-highlights">
                                                    @foreach ($infoRows as $feature)
                                                        <li>
                                                            <i class="fa fa-check-circle"></i>
                                                            <span>{{ $feature }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            <div class="product-feature-section-title">Características</div>
                                            <ul class="items product-feature-items">
                                                @foreach ($featureRows as $feature)
                                                    @php
                                                        $isOptional = str_contains(mb_strtolower((string) $feature, 'UTF-8'), 'opcional');
                                                        $cleanFeature = trim((string) preg_replace('/\s*\(opcional\)\s*/iu', '', (string) $feature));
                                                    @endphp
                                                    <li class="{{ $isOptional ? 'optional' : 'available' }}">
                                                        <div class="icon-holder">
                                                            <i class="fa {{ $isOptional ? 'fa-circle-o text-warning' : 'fa-check text-success' }}"></i>
                                                        </div>
                                                        <div class="desc">
                                                            <span class="text-black">{{ $cleanFeature }}</span>
                                                            @if ($isOptional)
                                                                <small class="product-feature-optional-label">Opcional</small>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="price-actions">
                                                <a href="{{ $plan['button_url'] ?? ($formModel->action_url ?? '/contacto') }}" class="btn">
                                                    {{ $plan['button_label'] ?? 'Solicitar' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        @if ($formModel && $formModel->is_active)
                            <div class="col-md-4 product-form-side">
                                @include('front.partials.dynamic-product-form', ['formModel' => $formModel, 'idPrefix' => 'producto'])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @elseif ($formModel && $formModel->is_active)
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    @include('front.partials.dynamic-product-form', ['formModel' => $formModel, 'idPrefix' => 'producto'])
                </div>
            </div>
        </div>
    @endif

    <div class="container py-5">
        

        @if (!empty($project->body))
            <hr>
            <div class="row">
                <div class="col-md-12">
                    {!! $project->body !!}
                </div>
            </div>
        @endif
    </div>
@endsection

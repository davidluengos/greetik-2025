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
                                    $pv = \App\Support\PricingTables\PricingPlanView::normalizeForView(is_array($plan) ? $plan : []);
                                @endphp
                                <div class="product-plan-col">
                                    <div class="pricing-table-two product-feature-card {{ $pv['highlighted'] ? 'highlighted' : '' }} wow fadeInUp">
                                        <div class="inner">
                                            <div class="title">{{ $pv['name'] }}</div>
                                            <div class="product-feature-price-wrap">
                                                @if ($pv['show_price_from'])
                                                    <p class="product-feature-price-label">Desde</p>
                                                @endif
                                                <p class="product-feature-price">{{ $pv['price'] }}</p>
                                            </div>
                                            @if (!empty($pv['description']))
                                                <p class="desc">{{ $pv['description'] }}</p>
                                            @endif
                                            @if ($pv['highlight_lines'] !== [])
                                                <ul class="product-plan-highlights">
                                                    @foreach ($pv['highlight_lines'] as $line)
                                                        <li>
                                                            <i class="fa fa-check-circle"></i>
                                                            <span>{{ $line }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            <div class="product-feature-section-title">Características</div>
                                            <ul class="items product-feature-items">
                                                @foreach ($pv['feature_items'] as $row)
                                                    <li class="{{ $row['optional'] ? 'optional' : 'available' }}">
                                                        <div class="icon-holder">
                                                            <i class="fa {{ $row['optional'] ? 'fa-circle-o text-warning' : 'fa-check text-success' }}"></i>
                                                        </div>
                                                        <div class="desc">
                                                            <span class="text-black">{{ $row['text'] }}</span>
                                                            @if ($row['optional'])
                                                                <small class="product-feature-optional-label">Opcional</small>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if ($pv['after_feature_lines'] !== [])
                                                @foreach ($pv['after_feature_lines'] as $afterLine)
                                                    <p class="desc">{{ $afterLine }}</p>
                                                @endforeach
                                            @endif
                                            <div class="price-actions">
                                                <a href="{{ $pv['button_url'] ?? ($formModel->action_url ?? '/contacto') }}" class="btn">
                                                    {{ $pv['button_label'] }}
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

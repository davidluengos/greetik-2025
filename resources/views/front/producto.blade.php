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

    @if ($formModel && $formModel->is_active)
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    @include('front.partials.dynamic-product-form', ['formModel' => $formModel, 'idPrefix' => 'producto'])
                </div>
            </div>
        </div>
    @endif

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
                    <div class="row">
                        <div class="price-two-container">
                            @foreach ($pricingModel->plans as $plan)
                                <div class="col-md-4">
                                    <div class="pricing-table-two {{ !empty($plan['highlighted']) ? 'highlighted' : '' }} wow fadeInUp">
                                        <div class="inner">
                                            <div class="title">
                                                {{ $plan['name'] ?? 'Plan' }}/
                                                <span class="price">{{ $plan['price'] ?? '-' }}</span>
                                            </div>
                                            @if (!empty($plan['description']))
                                                <p class="desc">{{ $plan['description'] }}</p>
                                            @endif
                                            <ul class="items">
                                                @foreach (($plan['features'] ?? []) as $feature)
                                                    <li class="available">
                                                        <div class="icon-holder">
                                                            <i class="fa fa-check text-success"></i>
                                                        </div>
                                                        <div class="desc">
                                                            <span class="text-black">{{ $feature }}</span>
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
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container py-5">
        <div class="row">
            <div class="col-md-7">
                @if (!empty($project->image))
                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="img-responsive img-thumbnail">
                @endif
            </div>
            <div class="col-md-5">
                <h2 class="mb-3">{{ $project->title }}</h2>
                @if (!empty($project->excerpt))
                    <p>{{ $project->excerpt }}</p>
                @endif
                @if (!empty($project->website_url))
                    <p>
                        <a href="{{ $project->website_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                            Ver proyecto
                        </a>
                    </p>
                @endif
            </div>
        </div>

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

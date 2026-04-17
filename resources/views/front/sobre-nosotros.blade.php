@extends('front.layouts.app')

@section('title', $page->meta_title ?: 'Greetik | ' . $page->title)

@section('content')
    @php
        $x = $page->extra ?? [];
        $slides = $x['carousel'] ?? [];
        if (!is_array($slides)) {
            $slides = [];
        }
        $hero = $x['hero_image'] ?? ($slides[0]['image'] ?? 'front/img/service3.jpg');
    @endphp

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1>{{ $page->title }}</h1>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">{{ $page->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-5">
                <div class="about-carousel wow fadeInLeft">
                    <div id="aboutPageCarousel" class="carousel slide">
                        <div class="carousel-inner">
                            @forelse ($slides as $idx => $slide)
                                <div class="item {{ $idx === 0 ? 'active' : '' }}">
                                    <img src="{{ asset($slide['image'] ?? $hero) }}" alt="">
                                    @if (!empty($slide['caption']))
                                        <div class="carousel-caption">
                                            <p>{{ $slide['caption'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="item active">
                                    <img src="{{ asset($hero) }}" alt="{{ $page->title }}">
                                </div>
                            @endforelse
                        </div>
                        @if (count($slides) > 1)
                            <a class="carousel-control left" href="#aboutPageCarousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="carousel-control right" href="#aboutPageCarousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div> -->
            <div class="col-lg-12 about wow fadeInRight">
                @if (!empty($page->body))
                    {!! $page->body !!}
                @endif
            </div>
        </div>
    </div>
@endsection

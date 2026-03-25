@extends('front.layouts.app')

@section('title', 'Greetik | ' . $item->title)

@section('content')
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-sm-6">
          <h1>{{ $item->title }}</h1>
        </div>
        <div class="col-lg-6 col-sm-6">
          <ol class="breadcrumb pull-right">
            <li><a href="{{ route('home') }}">Inicio</a></li>
            @if ($page)
              <li><a href="{{ route('portfolio.index') }}">{{ $page->title }}</a></li>
            @else
              <li><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
            @endif
            <li class="active">{{ $item->title }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="container py-5 portfolio-item-detail">
    <div class="row">
      @php
        $img = $item->image;
        if ($img && ! preg_match('#^https?://#i', $img)) {
            $img = asset($img);
        }
      @endphp
      @if ($img)
        <div class="col-md-5">
          <p class="text-center">
            <img src="{{ $img }}" alt="{{ $item->title }}" class="img-responsive" style="max-width: 100%; height: auto;">
          </p>
        </div>
        <div class="col-md-7">
      @else
        <div class="col-md-12">
      @endif
        @if ($item->excerpt)
          <p class="lead">{{ $item->excerpt }}</p>
        @endif
        @if ($item->client)
          <p><strong>Cliente:</strong> {{ $item->client }}</p>
        @endif
        @if ($item->category)
          <p><strong>Categoria:</strong> {{ $item->category }}</p>
        @endif
        @if ($item->completed_at)
          <p><strong>Finalizado:</strong> {{ $item->completed_at->format('d/m/Y') }}</p>
        @endif
        @if (!empty($item->body))
          <div class="portfolio-item-body">
            {!! $item->body !!}
          </div>
        @endif
        <p class="mar-t-30">
          <a href="{{ route('portfolio.index') }}" class="btn btn-default">&laquo; Volver al portfolio</a>
        </p>
      </div>
    </div>
  </div>
@endsection

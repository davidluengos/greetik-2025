@extends('front.layouts.app')

@section('title', $page->meta_title ?: 'Greetik | ' . $page->title)

@push('styles')
  <link href="{{ asset('front/css/magnific-popup.css') }}" rel="stylesheet">
@endpush

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

  @if (!empty($page->body))
    <div class="container mar-b-30 portfolio-page-intro">
      <div class="row">
        <div class="col-md-12">
          {!! $page->body !!}
        </div>
      </div>
    </div>
  @endif

  @if ($items->isNotEmpty() && $categorySlugs->count() > 1)
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <ul id="portfolio-filters" class="clearfix" aria-label="Filtros de categorias del portfolio">
            <li>
              <button type="button" class="filter portfolio-filter-chip active" data-filter="{{ $categorySlugs->implode(' ') }}">Todos</button>
            </li>
            @foreach ($categorySlugs as $catSlug)
              <li>
                <button type="button" class="filter portfolio-filter-chip" data-filter="{{ $catSlug }}">{{ $categoryLabels[$catSlug] ?? $catSlug }}</button>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <div class="container">
    <div class="row mar-b-30">
      <div id="portfoliolist" class="{{ $categorySlugs->count() > 1 ? '' : 'portfolio-no-filters' }}">
        <div class="col-md-12">
          @forelse ($items as $item)
            @php
              $catSlug = \Illuminate\Support\Str::slug($item->category ?: 'general');
              $img = $item->image;
              if ($img && ! preg_match('#^https?://#i', $img)) {
                  $img = asset($img);
              } elseif (! $img) {
                  $img = asset('front/img/portfolios/web/2.jpg');
              }
            @endphp
            <div class="portfolio {{ $catSlug }}" data-cat="{{ $catSlug }}">
              <div class="portfolio-wrapper">
                <div class="portfolio-hover">
                  <div class="image-caption">
                    <a href="{{ $img }}" class="label magnefig label-info icon" data-toggle="tooltip" data-placement="left" title="Ampliar"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('portfolio.show', $item->slug) }}" class="label label-info icon" data-toggle="tooltip" data-placement="top" title="Detalle"><i class="fa fa-link"></i></a>
                  </div>
                  <img src="{{ $img }}" alt="{{ $item->title }}" />
                </div>
              </div>
            </div>
          @empty
            <div class="col-md-12">
              <p class="text-muted">Aun no hay proyectos publicados en el portfolio.</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('front/js/mixitup.js') }}"></script>
  <script src="{{ asset('front/js/jquery.magnific-popup.js') }}"></script>
  <script>
    (function ($) {
      'use strict';

      var filterList = {
        init: function () {
          var $list = $('#portfoliolist');
          if ($list.length && $('.portfolio', $list).length && $('#portfolio-filters').length) {
            $list.mixitup({
              targetSelector: '.portfolio',
              filterSelector: '.filter',
              effects: ['fade'],
              easing: 'snap',
              onMixEnd: function () {
                filterList.hoverEffect();
              },
            });
          }
          filterList.hoverEffect();
        },
        hoverEffect: function () {
          $('#portfoliolist .portfolio .portfolio-hover').hover(
            function () {
              $(this).find('.image-caption').slideDown(250);
            },
            function () {
              $(this).find('.image-caption').slideUp(250);
            }
          );
        },
      };

      $(function () {
        $('.image-caption a').tooltip();
        filterList.init();

        $('.magnefig').each(function () {
          $(this).magnificPopup({
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
          });
        });
      });
    })(jQuery);
  </script>
@endpush

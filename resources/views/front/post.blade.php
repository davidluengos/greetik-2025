@extends('front.layouts.app')

@php
    $seoTitle = filled($post->metatitle)
        ? $post->metatitle
        : \App\Support\SiteBranding::pageTitle($post->title);

    if (filled($post->metadescription)) {
        $seoDescription = $post->metadescription;
    } else {
        $bodyText = preg_replace('/<\/(p|div|h[1-6]|li|br)\s*\/?>/i', ' ', (string) $post->body);
        $bodyText = html_entity_decode(strip_tags($bodyText), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $bodyText = trim(preg_replace('/\s+/', ' ', $bodyText));
        $seoDescription = \Illuminate\Support\Str::limit($bodyText, 160);
    }
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('og_type', 'article')
@section('og_title', $seoTitle)
@section('og_description', $seoDescription)
@section('twitter_title', $seoTitle)
@section('twitter_description', $seoDescription)

@section('content')
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-sm-4">
        <p class="h1">Blog Detail</p>
      </div>
      <div class="col-lg-8 col-sm-8">
        <ol class="breadcrumb pull-right">
          <li><a href="{{ route('home') }}">Inicio</a></li>
          <li><a href="{{ route('posts.index') }}">Blog</a></li>
          <li class="active">{{ \Illuminate\Support\Str::limit($post->title, 40) }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
  @php
    $authorName = (blank($post->user) || is_numeric($post->user)) ? 'Greetik' : $post->user;
  @endphp
  <div class="row">
    <div class="col-lg-9">
      <div class="blog-item">
        <div class="row">
          <div class="col-lg-2 col-sm-2">
            <div class="date-wrap">
              <span class="date">{{ optional($post->publishdate ?? $post->createdat)->format('d') }}</span>
              <span class="month">{{ optional($post->publishdate ?? $post->createdat)->translatedFormat('F') }}</span>
              <span class="year">{{ optional($post->publishdate ?? $post->createdat)->format('Y') }}</span>
            </div>
          </div>
          <div class="col-lg-10 col-sm-10">
            <h1>{{ $post->title }}</h1>
            <p class="text-muted">
              <i class="fa fa-user"></i> {{ $authorName }}
              <span class="pl-10 pr-10">|</span>
              <i class="fa fa-calendar"></i> {{ optional($post->publishdate ?? $post->createdat)->format('d/m/Y') }}
            </p>
            <div class="blog-content">
              {!! $post->body !!}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="blog-side-item">
        <div class="category">
          <h3>Etiquetas</h3>
          <ul class="list-unstyled">
            @forelse ($post->tags_array as $tag)
              <li>
                <a href="javascript:;">
                  <i class="fa fa-angle-right pr-10"></i>
                  {{ $tag }}
                </a>
              </li>
            @empty
              <li>
                <a href="javascript:;">
                  <i class="fa fa-angle-right pr-10"></i>
                  Sin etiquetas
                </a>
              </li>
            @endforelse
          </ul>
        </div>

        <div class="tags">
          <h3>Navegacion</h3>
          <ul class="tag">
            <li>
              <a href="{{ route('posts.index') }}">
                <i class="fa fa-tags pr-5"></i>
                Volver al blog
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

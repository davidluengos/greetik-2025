@extends('front.layouts.app')

@section('title', 'Acme | Blog')

@section('content')
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-sm-4">
        <h1>Blog</h1>
      </div>
      <div class="col-lg-8 col-sm-8">
        <ol class="breadcrumb pull-right">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li class="active">Blog</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
  @php
    $postRows = $posts->values()->chunk(2);
  @endphp

  @forelse ($postRows as $row)
    <div class="row blog-two-row">
      @foreach ($row as $columnIndex => $post)
        @php
          $authorName = (blank($post->user) || is_numeric($post->user)) ? 'Admin' : $post->user;
        @endphp
        <div class="col-md-6 blog-two-col">
          <div class="{{ $columnIndex === 0 ? 'blog-left' : 'blog-right' }} wow {{ $columnIndex === 0 ? 'fadeInLeft' : 'fadeInRight' }} blog-two-card">
            <div class="blog-content">
              <h3>
                <a href="{{ route('posts.show', ['slug' => \Illuminate\Support\Str::slug($post->title) . '-' . $post->id]) }}">
                  {{ $post->title }}
                </a>
              </h3>
              <p>{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($post->body), ENT_QUOTES | ENT_HTML5, 'UTF-8'), 260) }}</p>
            </div>
            <div class="blog-two-info">
              <p>
                <i class="fa fa-user"></i>
                {{ $authorName }}
                |
                <i class="fa fa-calendar"></i>
                {{ optional($post->publishdate ?? $post->createdat)->format('d/m/Y') }}
              </p>
            </div>
            <a class="btn btn-primary" href="{{ route('posts.show', ['slug' => \Illuminate\Support\Str::slug($post->title) . '-' . $post->id]) }}">
              Leer mas
            </a>
          </div>
        </div>
      @endforeach
    </div>
  @empty
    <div class="row">
      <div class="col-md-12">
        <p>No hay entradas publicadas.</p>
      </div>
    </div>
  @endforelse
</div>
@endsection
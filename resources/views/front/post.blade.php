@extends('front.layouts.app')

@section('title', 'Acme | Home')

@section('content')

<!-- Post Section -->
    <article class="post">
        <p>{{ $post->id }}</p>
        <a href="{{ route('posts.show', ['slug' => Str::slug($post->title) . '-' . $post->id]) }}">
            <h2>{{ $post->title }}</h2>
        </a>

        <!-- Post Body, mostrar texto enriquecido -->
        <div class="post-body">
            {!! $post->body !!}
        </div>

    </article>
@endsection

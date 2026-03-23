@extends('front.layouts.app')

@section('title', 'Acme | Home')

@section('content')

<!-- Posts Section -->

@foreach ($posts as $post)
    <article class="post">
        <p>{{ $post->id }}</p>
        
        <a href="{{ route('posts.show', ['slug' => Str::slug($post->title) . '-' . $post->id]) }}">
            <h2>{{ $post->title }}</h2>
        </a>

        <!-- Post Body, mostrar texto enriquecido, solo los primeros 100 caracteres -->
        <div class="post-body">
            {!! $post->body !!}
        </div>

    </article>
    
@endforeach

@endsection

@push('scripts')
<script>
  $(function() {
    $('#da-slider').cslider({
      autoplay    : true,
      bgincrement : 100
    });
  });
</script>
@endpush
<!-- Nota: Asegúrate de no incluir las etiquetas <html>, <head>, <body>, <header> o <footer> aquí, ya que esas partes ya están en el layout -->
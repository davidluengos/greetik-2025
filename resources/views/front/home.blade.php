@extends('front.layouts.app')

@section('title', $page->meta_title ?? 'Greetik | Home')

@section('content')

    @foreach ($sections as $sectionKey)
        @includeIf('front.home-sections.' . $sectionKey)
    @endforeach

@endsection
<!-- Nota: Asegúrate de no incluir las etiquetas <html>, <head>, <body>, <header> o <footer> aquí, ya que esas partes ya están en el layout -->

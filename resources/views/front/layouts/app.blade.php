<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Acme | Home')</title>

    <link rel="shortcut icon" href="{{ asset('front/img/favicon.png') }}">
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/flexslider.css') }}" rel="stylesheet"/>
    <link href="{{ asset('front/assets/bxslider/jquery.bxslider.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/owlcarousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/owlcarousel/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/superfish.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('front/css/component.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/style-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/parallax-slider/parallax-slider.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/css/custom.css') }}" rel="stylesheet" />
    @stack('styles')

    <script src="{{ asset('front/js/parallax-slider/modernizr.custom.28468.js') }}"></script>
  </head>
  <body>
    @include('front.layouts.header')

    <main>
      @yield('content')
    </main>

    @include('front.layouts.footer')

    <!-- Scripts -->
    <script src="{{ asset('front/js/jquery-1.8.3.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/hover-dropdown.js') }}"></script>
    <script src="{{ asset('front/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('front/assets/bxslider/jquery.bxslider.js') }}"></script>
    <script src="{{ asset('front/js/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ asset('front/js/wow.min.js') }}"></script>
    <script src="{{ asset('front/assets/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('front/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('front/js/link-hover.js') }}"></script>
    <script src="{{ asset('front/js/superfish.js') }}"></script>
    <script src="{{ asset('front/js/parallax-slider/jquery.cslider.js') }}"></script>
    <script src="{{ asset('front/js/common-scripts.js') }}"></script>

    @stack('scripts')
  </body>
</html>

@extends('front.layouts.app')

@section('title', $page->meta_title ?? 'Greetik | Home')

@section('content')

    <!-- Sequence Modern Slider -->
    <div id="da-slider" class="da-slider">

        <div class="da-slide">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2><i>{{ $hero['title'] }}</i></h2>
                        <h3><i>{{ $hero['subtitle'] }}</i></h3>
                        <p>{{ $hero['text'] }}</p>
                        
                        <a href="{{ $hero['primary_cta_url'] }}" class="btn btn-info btn-lg da-link">Solicita presupuesto en 24h</a>
                        <div class="da-img">
                            <img src="{{ asset($hero['image']) }}" alt="{{ $hero['title'] }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        

        
    </div>

    <div class="gray-box">
        <div class="container">
            <div class="row">
                <div class="text-center feature-head">
                    <h2>
                        Nuestros Servicios
                    </h2>
                    <p>
                        Soluciones digitales adaptadas a tu negocio.
                    </p>
                </div>

                <div class="services">
                    @forelse ($homeServices as $service)
                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="icon-wrap ico-bg round-five wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".1s">
                                <i class="{{ $service->icon ?: 'fa fa-cogs' }}"></i>
                            </div>
                            <h4>{{ $service->title }}</h4>
                            <p>{{ $service->home_short_text ?: $service->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $service->body), 140) }}</p>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No hay servicios destacados disponibles ahora mismo.</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center" style="margin-top: 20px;">
                    <a href="{{ route('contacto') }}" class="btn btn-primary">
                        Solicitar presupuesto
                    </a>
                </div>
            </div>
        </div>
    </div>




    <div class="container">
        <div class="row mar-b-50">
            <div class="col-md-12">
                <div class="text-center feature-head wow fadeInDown">
                    <h1 class="">
                        Desarrollo Web Profesional
                    </h1>

                </div>


                <div class="feature-box">
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="front/img/1.png" alt="" width="100" height="100">

                            </em>
                            <h4>
                                <b>Desarrollo de páginas web corporativas</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Diseñamos y desarrollamos páginas web modernas, rápidas y adaptadas a móviles.</br>
                            Perfectas para negocios que necesitan una presencia online profesional y que transmita confianza
                            a sus clientes.</br>
                            👉 Incluye: diseño personalizado, optimización para SEO básico y un panel de gestión sencillo
                            para que puedas actualizar tu contenido sin complicaciones.
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="front/img/2.png" alt="" width="100" height="100">
                            </em>
                            <h4>
                                <b>Tiendas online (e-commerce)</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Pon tu negocio a vender en Internet con una tienda online a medida.</br>
                            Desde un catálogo sencillo de productos hasta un e-commerce completo con carrito de compra,
                            métodos de pago y gestión de pedidos.</br>
                            👉 Ideal para empresas que quieren ampliar su mercado y aumentar ventas sin depender únicamente
                            del punto físico.
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="front/img/2.png" alt="" width="100" height="100">
                            </em>
                            <h4>
                                <b>Desarrollo a medida con Laravel</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Creamos aplicaciones y sistemas web totalmente personalizados con Laravel, uno de los frameworks
                            más potentes y seguros en PHP.</br>
                            ¿Necesitas un sistema de reservas, una intranet para tu equipo o una herramienta que automatice
                            procesos de tu empresa? Lo desarrollamos a medida, adaptado exactamente a tus necesidades.
                        </p>
                    </div>
                </div>

                <!--feature end-->
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {
            $('#da-slider').cslider({
                autoplay: true,
                bgincrement: 100
            });
        });
    </script>
@endpush
<!-- Nota: Asegúrate de no incluir las etiquetas <html>, <head>, <body>, <header> o <footer> aquí, ya que esas partes ya están en el layout -->

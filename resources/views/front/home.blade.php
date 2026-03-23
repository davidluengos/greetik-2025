@extends('front.layouts.app')

@section('title', 'Greetik | Home')

@section('content')

    <!-- Sequence Modern Slider -->
    <div id="da-slider" class="da-slider">

        <div class="da-slide">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>
                            <i>GREETIK Soluciones </i>
                        </h2>
                        <h3>
                            <i>Desarrollo Web Profesional</i>
                        </h3>
                        <p>
                            Creamos páginas web, tiendas online y aplicaciones a medida para impulsar tu negocio.
                        </p>
                        
                        <a href="#" class="btn btn-info btn-lg da-link">
                            Read more
                        </a>
                        <div class="da-img">
                            <img src="front/img/parallax-slider/images/desarrollo.png" alt="desarrollo" />
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
                    <!-- Webs corporativas -->
                    <div class="col-lg-3 col-sm-6 text-center">
                        <div class="icon-wrap ico-bg round-five wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".1s">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <h4>Webs corporativas</h4>
                        <p>Diseñamos páginas web modernas y adaptadas a móviles que transmiten profesionalidad y confianza a
                            tus clientes.</p>
                    </div>

                    <!-- Tiendas online -->
                    <div class="col-lg-3 col-sm-6 text-center">
                        <div class="icon-wrap ico-bg round-five wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".3s">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <h4>Tiendas online</h4>
                        <p>Creamos tiendas online completas, con carrito, pagos y gestión de pedidos, para que vendas sin
                            límites desde tu web.</p>
                    </div>

                    <!-- Desarrollo a medida -->
                    <div class="col-lg-3 col-sm-6 text-center">
                        <div class="icon-wrap ico-bg round-five wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".5s">
                            <i class="fa fa-code"></i>
                        </div>
                        <h4>Desarrollo a medida</h4>
                        <p>Desarrollamos aplicaciones y sistemas personalizados en Laravel, adaptados exactamente a las
                            necesidades de tu negocio.</p>
                    </div>

                    <!-- Mantenimiento y soporte -->
                    <div class="col-lg-3 col-sm-6 text-center">
                        <div class="icon-wrap ico-bg round-five wow zoomIn" data-wow-duration="1.5s" data-wow-delay=".7s">
                            <i class="fa fa-life-ring"></i>
                        </div>
                        <h4>Mantenimiento y soporte</h4>
                        <p>Nos ocupamos de que tu web o aplicación funcione siempre de forma óptima, con soporte técnico
                            rápido y actualizaciones constantes.</p>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 20px;">
                    <a href="/servicios" class="btn btn-primary">
                        Ver todos los servicios
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

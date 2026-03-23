@extends('front.layouts.app')

@section('title', 'Greetik | Servicios')

@section('content')
    <!--breadcrumbs start-->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <h1>Servicios</h1>
                </div>
                <div class="col-lg-8 col-sm-8">
                    <ol class="breadcrumb pull-right">
                        <li><a href="#">Home</a></li>
                        <li class="active">Servicios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->

    <!-- Sección de servicios -->
    <div class="gray-bg price-container py-5">
        <div class="container">

            <div class="text-center mb-5">
                <h1 class="wow flipInX">Nuestros Servicios</h1>
                <p class="wow fadeIn">
                    En Greetik ayudamos a empresas y profesionales a crecer en el entorno digital
                    con soluciones personalizadas. Sabemos que cada proyecto es único, por eso
                    ofrecemos desde páginas web corporativas y tiendas online hasta aplicaciones a medida
                    y soporte técnico continuo.
                </p>
                <p class="wow fadeIn" data-wow-delay="0.2s">
                    Nos encargamos de todo el proceso: diseño, desarrollo, optimización y mantenimiento,
                    para que tú solo tengas que preocuparte de tu negocio.
                    Nuestro objetivo es que tu presencia online no solo se vea bien, sino que realmente funcione.
                </p>
            </div>

            <div class="row g-4 services-grid">
                <div class="col-lg-6 col-md-6 col-12 d-flex">
                    <!-- Webs corporativas -->
                    <div class="service-card-wrapper wow fadeInUp w-100">
                        <div class="service-card h-100 service-web">
                            <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3">
                                <i class="fa fa-desktop"></i>
                            </div>
                            <h2>Webs corporativas</h2>
                            <p>Diseñamos páginas modernas, rápidas y adaptadas a cualquier dispositivo. Creamos sitios que
                                transmiten profesionalidad y confianza a tus clientes, con un diseño a medida que refleja la
                                identidad de tu empresa. Todas nuestras webs incluyen optimización SEO básica, carga rápida
                                y un gestor de contenidos sencillo para que puedas mantenerla actualizada sin
                                complicaciones.</p>
                            <div class="mt-auto">
                                <a href="#contacto" class="btn">Solicita tu web</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex">
                    <!-- Aplicaciones web -->
                    <div class="service-card-wrapper wow fadeInUp w-100" data-wow-delay="0.2s">
                        <div class="service-card h-100 service-apps">
                            <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3" data-wow-delay="0.2s">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <h2>Aplicaciones web</h2>
                            <p>Construimos aplicaciones web a medida que se adaptan a los procesos de tu negocio. Desde
                                sistemas de reservas hasta plataformas de gestión internas, nos ocupamos de todo el ciclo:
                                análisis, diseño, desarrollo e implementación. Trabajamos con tecnologías modernas, cuidando
                                la seguridad y la escalabilidad para que tu aplicación crezca contigo.</p>
                            <div class="mt-auto">
                                <a href="#contacto" class="btn">Solicita tu app</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex">
                    <!-- Tiendas online -->
                    <div class="service-card-wrapper wow fadeInUp w-100" data-wow-delay="0.1s">
                        <div class="service-card h-100 service-ecommerce">
                            <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3" data-wow-delay="0.1s">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <h2>Tiendas online</h2>
                            <p>Desarrollamos e-commerce optimizados para vender más. Incluimos pasarela de pago segura,
                                gestión de inventario, configuración de envíos y diseño orientado a la conversión. Además,
                                integramos herramientas de marketing digital y analítica para que puedas conocer mejor a
                                tus clientes y aumentar tus ventas.</p>
                            <div class="mt-auto">
                                <a href="#contacto" class="btn">Lanza tu tienda</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex">
                    <!-- Mantenimiento y soporte -->
                    <div class="service-card-wrapper wow fadeInUp w-100" data-wow-delay="0.3s">
                        <div class="service-card h-100 service-support">
                            <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3" data-wow-delay="0.3s">
                                <i class="fa fa-wrench"></i>
                            </div>
                            <h2>Mantenimiento y soporte</h2>
                            <p>Nos encargamos de que tu web o aplicación esté siempre al día y funcionando sin problemas.
                                Ofrecemos planes de mantenimiento que incluyen actualizaciones periódicas, copias de
                                seguridad, monitorización de seguridad y asistencia personalizada para resolver cualquier
                                incidencia técnica de forma rápida y eficaz.</p>
                            <div class="mt-auto">
                                <a href="#contacto" class="btn">Solicita soporte</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex">
                    <!-- APIs REST -->
                    <div class="service-card-wrapper wow fadeInUp w-100" data-wow-delay="0.4s">
                        <div class="service-card h-100 service-api">
                            <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3" data-wow-delay="0.4s">
                                <i class="fa fa-puzzle-piece"></i>
                            </div>
                            <h2>APIs REST</h2>
                            <p>Desarrollamos APIs REST robustas y escalables para conectar tus aplicaciones, sistemas y servicios. 
                                Diseñamos arquitecturas que permiten la integración perfecta entre diferentes plataformas, 
                                con documentación completa, autenticación segura y endpoints optimizados para el mejor rendimiento 
                                y experiencia de desarrollo.</p>
                            <div class="mt-auto">
                                <a href="#contacto" class="btn">Desarrolla tu API</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex">
                    <!-- Diseño gráfico -->
                    <div class="service-card-wrapper wow fadeInUp w-100" data-wow-delay="0.5s">
                        <div class="service-card h-100 service-design">
                            <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3" data-wow-delay="0.5s">
                                <i class="fa fa-pencil"></i>
                            </div>
                            <h2>Diseño gráfico</h2>
                            <p>Creamos la identidad visual de tu marca con logos únicos, material corporativo y elementos gráficos 
                                que transmiten profesionalidad. Desde el diseño conceptual hasta la aplicación en diferentes medios, 
                                nos aseguramos de que tu imagen corporativa sea coherente, memorable y refleje los valores 
                                de tu empresa en cada detalle.</p>
                            <div class="mt-auto">
                                <a href="#contacto" class="btn">Diseña tu marca</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin sección de servicios -->

    <!-- Tecnologías start -->
    <div class="technologies-section py-5 bg-white">
        <div class="container text-center">
            <h2 class="mb-4 wow fadeInUp">Tecnologías que utilizamos</h2>
            <p class="mb-5 wow fadeInUp text-muted" data-wow-delay="0.1s">
                Trabajamos con tecnologías modernas y fiables que nos permiten crear proyectos robustos, seguros y
                escalables para impulsar tu negocio digital.
            </p>

            <div class="row justify-content-center">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/php.png') }}" alt="PHP" class="tech-img">
                        </div>
                        <h5>PHP</h5>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.1s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/laravel.png') }}" alt="Laravel" class="tech-img">
                        </div>
                        <h5>Laravel</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.2s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/html5.png') }}" alt="HTML5" class="tech-img">
                        </div>
                        <h5>HTML5</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.3s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/css3.png') }}" alt="CSS3" class="tech-img">
                        </div>
                        <h5>CSS3</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.4s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/javascript.png') }}" alt="JavaScript" class="tech-img">
                        </div>
                        <h5>JavaScript</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.5s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/api-rest.png') }}" alt="API REST" class="tech-img">
                        </div>
                        <h5>API REST</h5>
                        <div class="tech-badge">Especialidad</div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.6s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/photoshop.png') }}" alt="Adobe Photoshop" class="tech-img">
                        </div>
                        <h5>Photoshop</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.7s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/mysql.png') }}" alt="MySQL" class="tech-img">
                        </div>
                        <h5>MySQL</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.8s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/git.png') }}" alt="Git" class="tech-img">
                        </div>
                        <h5>Git</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="0.9s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/wordpress.png') }}" alt="WordPress" class="tech-img">
                        </div>
                        <h5>WordPress</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="1s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/docker.png') }}" alt="Docker" class="tech-img">
                        </div>
                        <h5>Docker</h5>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="tech-card wow zoomIn" data-wow-delay="1.1s">
                        <div class="tech-logo">
                            <img src="{{ asset('front/img/technologies/bootstrap.png') }}" alt="Bootstrap" class="tech-img">
                        </div>
                        <h5>Bootstrap</h5>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Tecnologías end -->


    <!--cta start-->
    <div class="cta-section py-5 bg-primary text-white text-center">
        <div class="container">
            <h2 class="mb-3 wow fadeInUp">¿Listo para impulsar tu negocio online?</h2>
            <p class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                Cuéntanos tu idea y te prepararemos una propuesta personalizada.
                En Greetik nos encargamos de que tu web o aplicación funcione, crezca y atraiga clientes.
            </p>
            <a href="#contacto" class="btn btn-cta wow zoomIn" data-wow-delay="0.3s">
                Solicita presupuesto
            </a>
        </div>
    </div>
    <!--cta end-->



@endsection

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

            @php
                $serviceClassMap = [
                    'webs-corporativas' => 'service-web',
                    'aplicaciones-web' => 'service-apps',
                    'tiendas-online' => 'service-ecommerce',
                    'mantenimiento-y-soporte' => 'service-support',
                    'apis-rest' => 'service-api',
                    'diseno-grafico' => 'service-design',
                ];
            @endphp
            <div class="row g-4 services-grid text-center">
                @forelse ($services as $service)
                    @php
                        $cardClass = $serviceClassMap[$service->slug] ?? '';
                        $iconClass = $service->icon ?: 'fa fa-cogs';
                    @endphp
                    <div class="col-lg-6 col-md-6 col-12 d-flex" id="servicio-{{ $service->slug }}">
                        <div class="service-card-wrapper wow fadeInUp w-100">
                            <div class="service-card h-100 text-center {{ $cardClass }}">
                                <div class="icon-wrap-services ico-bg round-five wow zoomIn mb-3">
                                    <i class="{{ $iconClass }}"></i>
                                </div>
                                <h2>{{ $service->title }}</h2>
                                <p>{{ $service->body ?: $service->excerpt }}</p>
                                <div class="mt-auto d-flex justify-content-center">
                                    <a href="/contacto" class="btn">Solicita informacion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">No hay servicios publicados por el momento.</p>
                    </div>
                @endforelse
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

            <div class="row technologies-grid text-center">
                @forelse ($technologies as $technology)
                    @php
                        $imagePath = $technology->image ?: 'front/img/technologies/php.png';
                    @endphp
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 d-flex justify-content-center">
                        <div class="tech-card wow zoomIn text-center">
                            <div class="tech-logo">
                                <img src="{{ asset($imagePath) }}" alt="{{ $technology->title }}" class="tech-img">
                            </div>
                            <h5>{{ $technology->title }}</h5>
                            @if (!empty($technology->badge))
                                <div class="tech-badge">{{ $technology->badge }}</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted mb-0">No hay tecnologías publicadas por el momento.</p>
                    </div>
                @endforelse
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

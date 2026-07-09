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

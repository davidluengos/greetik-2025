@if ($featuredProducts->isNotEmpty())
    @php $featuredUseCarousel = $featuredProducts->count() > 2; @endphp
    <div class="home-featured-products">
        <div class="container">
            <div id="home-featured-carousel" class="{{ $featuredUseCarousel ? 'owl-carousel home-featured-carousel' : 'row' }}">
                @foreach ($featuredProducts as $product)
                    <div class="{{ $featuredUseCarousel ? 'item' : 'col-md-6' }}">
                        <div class="home-featured-card">
                            <span class="home-featured-badge">{{ $sectionText['featured_products_label'] }}</span>

                            @if ($product->image)
                                <div class="home-featured-media">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}">
                                </div>
                            @endif

                            <h3 class="home-featured-title">{{ $product->title }}</h3>
                            @if (filled($product->subtitle))
                                <p class="home-featured-subtitle">{{ $product->subtitle }}</p>
                            @endif

                            @if (filled($product->excerpt))
                                <p class="home-featured-text">{{ $product->excerpt }}</p>
                            @endif

                            <div class="home-featured-actions">
                                <a href="{{ route('productos.show', $product->slug) }}" class="btn btn-info">Más información</a>
                                @if (filled($product->website_url))
                                    <a href="{{ $product->website_url }}" class="btn btn-default" target="_blank" rel="noopener">Ver {{ $product->title }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if ($featuredUseCarousel)
        @push('scripts')
            <script>
                $(function () {
                    $('#home-featured-carousel').owlCarousel({
                        items: 2,
                        itemsDesktop: [1199, 2],
                        itemsDesktopSmall: [980, 2],
                        itemsTablet: [768, 1],
                        itemsMobile: [480, 1],
                        navigation: true,
                        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                        pagination: true,
                        autoPlay: false
                    });
                });
            </script>
        @endpush
    @endif
@endif

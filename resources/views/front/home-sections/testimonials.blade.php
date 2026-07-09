@if ($testimonials->isNotEmpty())
    @php $testimonialsUseCarousel = $testimonials->count() > 3; @endphp
    <div class="home-testimonials gray-box">
        <div class="container">
            <div class="row">
                <div class="text-center feature-head">
                    <h2>{{ $sectionText['testimonials_title'] }}</h2>
                </div>
            </div>
            <div id="home-testimonials-carousel" class="{{ $testimonialsUseCarousel ? 'owl-carousel home-testimonials-carousel' : 'row' }}">
                @foreach ($testimonials as $testimonial)
                    <div class="{{ $testimonialsUseCarousel ? 'item' : 'col-md-6 col-lg-4' }}">
                        <div class="home-testimonial-card">
                            <div class="home-testimonial-quote">
                                <i class="fa fa-quote-left"></i>
                                <p>{{ $testimonial->quote }}</p>
                            </div>
                            <div class="home-testimonial-author">
                                @if ($testimonial->photo)
                                    <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->author }}" class="home-testimonial-photo">
                                @else
                                    <span class="home-testimonial-photo home-testimonial-photo-placeholder">
                                        <i class="fa fa-user"></i>
                                    </span>
                                @endif
                                <div class="home-testimonial-meta">
                                    <strong>{{ $testimonial->author }}</strong>
                                    @if (filled($testimonial->role))
                                        <span>{{ $testimonial->role }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if ($testimonialsUseCarousel)
        @push('scripts')
            <script>
                $(function () {
                    $('#home-testimonials-carousel').owlCarousel({
                        items: 3,
                        itemsDesktop: [1199, 3],
                        itemsDesktopSmall: [980, 2],
                        itemsTablet: [768, 2],
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

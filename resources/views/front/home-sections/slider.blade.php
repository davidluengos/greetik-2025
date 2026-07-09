<!-- Sequence Modern Slider -->
@php
    $heroHasBgImage = filled($hero['background_image'] ?? null);
    $heroBgColor = $hero['background_color'] ?? '#e9ecef';
    $heroSliderStyle = $heroHasBgImage
        ? sprintf(
            'background-image:url(%s);background-repeat:no-repeat;background-size:cover;background-position:center center;',
            json_encode(asset($hero['background_image']), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP
            )
        )
        : 'background-image:none;background-color:'.$heroBgColor.';';
@endphp
<div id="da-slider" class="da-slider" style="{{ $heroSliderStyle }}">

    <div class="da-slide">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $heroEyebrow = mb_strtoupper((string) ($hero['title'] ?? ''), 'UTF-8');
                        $heroHeadlineRaw = (string) ($hero['subtitle'] ?? '');
                        $heroHeadlineHtml = e($heroHeadlineRaw);

                        if (preg_match('/\[\[(.+?)\]\]/u', $heroHeadlineRaw)) {
                            $heroHeadlineHtml = preg_replace_callback(
                                '/\[\[(.+?)\]\]/u',
                                static fn ($m) => '<span class="da-slide-headline-highlight">' . e($m[1]) . '</span>',
                                $heroHeadlineHtml
                            ) ?? $heroHeadlineHtml;
                        } else {
                            $heroHeadlineHtml = preg_replace(
                                '/\b(crecen|resultados|escalables)\b/ui',
                                '<span class="da-slide-headline-highlight">$1</span>',
                                $heroHeadlineHtml,
                                1
                            ) ?? $heroHeadlineHtml;
                        }
                    @endphp
                    <div class="da-slide-desktop-copy">
                        <h3 class="da-slide-eyebrow"><i>{{ $heroEyebrow }}</i></h3>
                        <h2 class="da-slide-headline"><i>{!! $heroHeadlineHtml !!}</i></h2>
                        <p>{{ $hero['text'] }}</p>
                    </div>

                    <div class="da-img">
                        <img src="{{ asset($hero['image']) }}" alt="{{ $hero['title'] }}" />
                    </div>

                    <div class="da-slide-cta-row da-link da-slide-desktop-cta">
                        <a href="{{ $hero['primary_cta_url'] }}" class="btn btn-info btn-lg da-slide-cta-btn da-slide-cta-btn-primary">{{ $hero['primary_cta_text'] }}</a>
                        @if (filled($hero['secondary_cta_url'] ?? null))
                            <a href="{{ $hero['secondary_cta_url'] }}" class="btn btn-default btn-lg da-slide-cta-btn da-slide-cta-btn-secondary">{{ filled($hero['secondary_cta_text'] ?? null) ? $hero['secondary_cta_text'] : 'Ver más' }}</a>
                        @endif
                    </div>

                    <div class="da-slide-mobile-copy">
                        <h3 class="da-slide-eyebrow"><i>{{ $heroEyebrow }}</i></h3>
                        <h2 class="da-slide-headline"><i>{!! $heroHeadlineHtml !!}</i></h2>
                        <p>{{ $hero['text'] }}</p>
                        <div class="da-slide-mobile-cta-row">
                            <a href="{{ $hero['primary_cta_url'] }}" class="btn btn-info btn-lg da-slide-cta-btn da-slide-cta-btn-primary">{{ $hero['primary_cta_text'] }}</a>
                            @if (filled($hero['secondary_cta_url'] ?? null))
                                <a href="{{ $hero['secondary_cta_url'] }}" class="btn btn-default btn-lg da-slide-cta-btn da-slide-cta-btn-secondary">{{ filled($hero['secondary_cta_text'] ?? null) ? $hero['secondary_cta_text'] : 'Ver más' }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

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

@if (!empty($valueProps))
    <div class="home-value-props">
        <div class="container">
            <div class="row">
                <div class="text-center feature-head wow fadeInDown">
                    <h2>{{ $sectionText['value_props_title'] }}</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($valueProps as $prop)
                    @php
                        $propIcon = trim((string) ($prop['icon'] ?? '')) ?: 'fa fa-check-circle';
                        $propTitle = (string) ($prop['title'] ?? '');
                        $propText = (string) ($prop['text'] ?? '');
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="home-value-prop wow fadeInUp">
                            <div class="home-value-prop-icon">
                                <i class="{{ $propIcon }}"></i>
                            </div>
                            <h4 class="home-value-prop-title">{{ $propTitle }}</h4>
                            <p class="home-value-prop-text">{{ $propText }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

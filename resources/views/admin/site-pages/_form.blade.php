@php
    $x = $page->extra ?? [];
@endphp

@if ($page->slug === 'portfolio')
    <div class="alert alert-info small">
        Este contenido es la introduccion de la galeria publica en
        <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener">/portfolio</a>.
        Los proyectos se administran en
        <a href="{{ route('admin.portfolio-items.index') }}">Portfolio &raquo; elementos</a>.
    </div>
@endif

@if ($page->slug === 'home')
    <div class="alert alert-info small">
        Estos campos alimentan el bloque principal (slider) de la
        <a href="{{ url('/') }}" target="_blank" rel="noopener">portada</a>.
    </div>
    <hr>
    <h5 class="text-primary">Portada: bloque principal</h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="hero_title">Titulo (linea 1)</label>
            <input type="text" class="form-control @error('hero_title') is-invalid @enderror" id="hero_title" name="hero_title"
                value="{{ old('hero_title', $x['hero_title'] ?? '') }}">
            @error('hero_title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="hero_subtitle">Subtitulo (linea 2)</label>
            <input type="text" class="form-control @error('hero_subtitle') is-invalid @enderror" id="hero_subtitle" name="hero_subtitle"
                value="{{ old('hero_subtitle', $x['hero_subtitle'] ?? '') }}">
            @error('hero_subtitle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="hero_text">Texto (parrafo)</label>
        <textarea class="form-control @error('hero_text') is-invalid @enderror" id="hero_text" name="hero_text" rows="3">{{ old('hero_text', $x['hero_text'] ?? '') }}</textarea>
        @error('hero_text')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="hero_image_home">Imagen lateral del hero (ruta bajo <code>public/</code>)</label>
        <input type="text" class="form-control @error('hero_image') is-invalid @enderror" id="hero_image_home" name="hero_image"
            value="{{ old('hero_image', $x['hero_image'] ?? '') }}" placeholder="front/img/parallax-slider/images/desarrollo.png">
        @error('hero_image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <h6 class="text-secondary mt-3">Fondo del slider</h6>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="hero_background_image_file">Subir imagen de fondo</label>
            <input type="file" class="form-control-file @error('hero_background_image_file') is-invalid @enderror" id="hero_background_image_file" name="hero_background_image_file" accept="image/*">
            @error('hero_background_image_file')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Se guarda en <code>storage/app/public/home-hero</code> (requiere <code>php artisan storage:link</code>).</small>
        </div>
        <div class="form-group col-md-6">
            <label for="hero_background_color">Color de fondo si no hay imagen (hex)</label>
            @php
                $bgc = old('hero_background_color', $x['hero_background_color'] ?? '#e9ecef');
                if (! is_string($bgc)) {
                    $bgc = '#e9ecef';
                }
                $pickerHex = '#e9ecef';
                if (preg_match('/^#([\da-fA-F]{3})$/', $bgc, $m)) {
                    $s = $m[1];
                    $pickerHex = '#'.$s[0].$s[0].$s[1].$s[1].$s[2].$s[2];
                } elseif (preg_match('/^#([\da-fA-F]{6})$/', $bgc)) {
                    $pickerHex = $bgc;
                } elseif (preg_match('/^#([\da-fA-F]{8})$/', $bgc)) {
                    $pickerHex = substr($bgc, 0, 7);
                }
            @endphp
            <div class="d-flex flex-wrap align-items-center gap-2">
                <input type="color" class="form-control form-control-color @error('hero_background_color') is-invalid @enderror" id="hero_background_color_picker" value="{{ $pickerHex }}" title="Elegir color">
                <input type="text" class="form-control flex-grow-1 @error('hero_background_color') is-invalid @enderror" id="hero_background_color" name="hero_background_color"
                    value="{{ $bgc }}" placeholder="#e9ecef" maxlength="12" autocomplete="off">
            </div>
            @error('hero_background_color')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="hero_background_image">Ruta imagen de fondo (opcional, manual)</label>
        <input type="text" class="form-control @error('hero_background_image') is-invalid @enderror" id="hero_background_image" name="hero_background_image"
            value="{{ old('hero_background_image', $x['hero_background_image'] ?? '') }}" placeholder="storage/home-hero/....jpg">
        @error('hero_background_image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        @php
            $heroBgPreview = old('hero_background_image', $x['hero_background_image'] ?? '');
        @endphp
        @if (! empty($heroBgPreview))
            <div class="mt-2">
                <span class="text-muted small">Vista previa:</span><br>
                <img src="{{ asset($heroBgPreview) }}" alt="" class="img-thumbnail mt-1" style="max-height:120px">
            </div>
        @endif
    </div>
    <div class="form-group form-check">
        <input type="hidden" name="clear_hero_background_image" value="0">
        <input type="checkbox" class="form-check-input" id="clear_hero_background_image" name="clear_hero_background_image" value="1"
            {{ old('clear_hero_background_image') ? 'checked' : '' }}>
        <label class="form-check-label" for="clear_hero_background_image">Quitar imagen de fondo</label>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="hero_primary_cta_text">Texto del boton principal</label>
            <input type="text" class="form-control @error('hero_primary_cta_text') is-invalid @enderror" id="hero_primary_cta_text" name="hero_primary_cta_text"
                value="{{ old('hero_primary_cta_text', $x['hero_primary_cta_text'] ?? '') }}">
            @error('hero_primary_cta_text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="hero_primary_cta_url">URL del boton principal</label>
            <input type="text" class="form-control @error('hero_primary_cta_url') is-invalid @enderror" id="hero_primary_cta_url" name="hero_primary_cta_url"
                value="{{ old('hero_primary_cta_url', $x['hero_primary_cta_url'] ?? '') }}" placeholder="/contacto">
            @error('hero_primary_cta_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <h6 class="text-secondary mt-2">Segundo boton (opcional)</h6>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="hero_secondary_cta_text">Texto</label>
            <input type="text" class="form-control @error('hero_secondary_cta_text') is-invalid @enderror" id="hero_secondary_cta_text" name="hero_secondary_cta_text"
                value="{{ old('hero_secondary_cta_text', $x['hero_secondary_cta_text'] ?? '') }}">
            @error('hero_secondary_cta_text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="hero_secondary_cta_url">URL</label>
            <input type="text" class="form-control @error('hero_secondary_cta_url') is-invalid @enderror" id="hero_secondary_cta_url" name="hero_secondary_cta_url"
                value="{{ old('hero_secondary_cta_url', $x['hero_secondary_cta_url'] ?? '') }}" placeholder="/portfolio">
            @error('hero_secondary_cta_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endif

<div class="form-group">
    <label for="title">Titulo de pagina</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $page->title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="meta_title">Meta title (SEO)</label>
        <input type="text" class="form-control" id="meta_title" name="meta_title"
            value="{{ old('meta_title', $page->meta_title) }}">
    </div>
    <div class="form-group col-md-6">
        <label for="meta_description">Meta description</label>
        <input type="text" class="form-control" id="meta_description" name="meta_description"
            value="{{ old('meta_description', $page->meta_description) }}">
    </div>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Pagina visible en la web</label>
</div>

@if ($page->slug === 'sobre-nosotros')
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="hero_image">Imagen principal (ruta)</label>
            <input type="text" class="form-control" id="hero_image" name="hero_image"
                value="{{ old('hero_image', $x['hero_image'] ?? '') }}" placeholder="front/img/service3.jpg">
        </div>
    </div>
    <div class="form-group">
        <label for="carousel_json">Carrusel (JSON): array de { image, caption }</label>
        <textarea class="form-control @error('carousel_json') is-invalid @enderror" id="carousel_json" name="carousel_json" rows="8">{{ old('carousel_json', json_encode($x['carousel'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) }}</textarea>
        @error('carousel_json')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
@endif

@if ($page->slug === 'contacto')
    <hr>
    <h5 class="text-primary">Bloque lateral (datos de contacto)</h5>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="address_title">Titulo direccion</label>
            <input type="text" class="form-control" id="address_title" name="address_title"
                value="{{ old('address_title', $x['address_title'] ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="hours_title">Titulo horario</label>
            <input type="text" class="form-control" id="hours_title" name="hours_title"
                value="{{ old('hours_title', $x['hours_title'] ?? '') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="address">Direccion (varias lineas)</label>
        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $x['address'] ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="hours">Horario (varias lineas)</label>
        <textarea class="form-control" id="hours" name="hours" rows="3">{{ old('hours', $x['hours'] ?? '') }}</textarea>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="phones_title">Titulo telefonos</label>
            <input type="text" class="form-control" id="phones_title" name="phones_title"
                value="{{ old('phones_title', $x['phones_title'] ?? '') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="product_form_id">Formulario del bloque derecho</label>
            <select class="form-control @error('product_form_id') is-invalid @enderror" id="product_form_id" name="product_form_id">
                <option value="">Formulario basico (nombre, email, telefono, mensaje)</option>
                @foreach ($productForms as $pf)
                    <option value="{{ $pf->id }}" @selected((string) old('product_form_id', $x['product_form_id'] ?? '') === (string) $pf->id)>
                        {{ $pf->name }}@if (!$pf->is_active) (inactivo) @endif
                    </option>
                @endforeach
            </select>
            @error('product_form_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">O crea uno reutilizable en <a href="{{ route('admin.product-forms.index') }}" target="_blank">Formularios</a>.</small>
        </div>
    </div>
    <div class="form-group">
        <label for="phones_text">Telefonos (uno por linea)</label>
        <textarea class="form-control" id="phones_text" name="phones_text" rows="3">{{ old('phones_text', isset($x['phones']) && is_array($x['phones']) ? implode("\n", $x['phones']) : '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="email">Email de contacto</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email', $x['email'] ?? '') }}" placeholder="hola@tu-dominio.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="form_heading">Titulo sobre el formulario</label>
        <input type="text" class="form-control" id="form_heading" name="form_heading"
            value="{{ old('form_heading', $x['form_heading'] ?? '') }}">
    </div>
    <div class="form-group">
        <label for="map_embed">Mapa embebido (HTML del iframe, opcional)</label>
        <textarea class="form-control" id="map_embed" name="map_embed" rows="4"
            placeholder="Pega aqui el codigo iframe de Google Maps u otro">{{ old('map_embed', $x['map_embed'] ?? '') }}</textarea>
    </div>
@endif

<hr>
<h5 class="text-primary">Contenido principal</h5>
<div class="form-group">
    <label for="body">Texto (HTML / enriquecido)</label>
    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="12">{{ old('body', $page->body) }}</textarea>
    @error('body')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.site-pages.index') }}" class="btn btn-secondary">Volver</a>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        (function () {
            if (typeof tinymce === 'undefined') {
                return;
            }
            tinymce.remove('#body');
            tinymce.init({
                selector: '#body',
                height: {{ $page->slug === 'contacto' ? 280 : 420 }},
                menubar: 'file edit view insert format tools table help',
                plugins: 'code link lists table image fullscreen preview searchreplace wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | code fullscreen preview',
                block_formats: 'Parrafo=p; Encabezado 2=h2; Encabezado 3=h3; Encabezado 4=h4; Cita=blockquote',
                branding: false,
                promotion: false,
                relative_urls: false,
                convert_urls: false
            });
        })();
    </script>
    @if ($page->slug === 'home')
        <script>
            (function () {
                var picker = document.getElementById('hero_background_color_picker');
                var text = document.getElementById('hero_background_color');
                if (!picker || !text) {
                    return;
                }
                picker.addEventListener('input', function () {
                    var v = text.value.trim();
                    if (/^#[\da-fA-F]{8}$/i.test(v)) {
                        text.value = picker.value + v.slice(7);
                    } else {
                        text.value = picker.value;
                    }
                });
            })();
        </script>
    @endif
@endpush

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
@endpush

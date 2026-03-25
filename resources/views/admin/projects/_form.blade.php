@csrf

<div class="form-group">
    <label for="title">Titulo</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $project->title) }}" required>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
            value="{{ old('slug', $project->slug) }}">
    </div>
    <div class="form-group col-md-3">
        <label for="menu_order">Orden</label>
        <input type="number" class="form-control" id="menu_order" name="menu_order"
            value="{{ old('menu_order', $project->menu_order ?? 0) }}" min="0">
    </div>
    <div class="form-group col-md-3">
        <label for="published_at">Publicacion</label>
        <input type="datetime-local" class="form-control" id="published_at" name="published_at"
            value="{{ old('published_at', optional($project->published_at)->format('Y-m-d\TH:i')) }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="product_form_id">Formulario (opcional)</label>
        <select class="form-control @error('product_form_id') is-invalid @enderror" id="product_form_id" name="product_form_id">
            <option value="">Ninguno</option>
            @foreach ($productForms ?? [] as $pf)
                <option value="{{ $pf->id }}" @selected((string) old('product_form_id', $project->product_form_id) === (string) $pf->id)>
                    {{ $pf->name }}@if (!$pf->is_active) (inactivo) @endif
                </option>
            @endforeach
        </select>
        @error('product_form_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted"><a href="{{ route('admin.product-forms.index') }}" target="_blank">Gestionar formularios</a></small>
    </div>
    <div class="form-group col-md-6">
        <label for="pricing_table_id">Tabla de precios (opcional)</label>
        <select class="form-control @error('pricing_table_id') is-invalid @enderror" id="pricing_table_id" name="pricing_table_id">
            <option value="">Ninguna</option>
            @foreach ($pricingTables ?? [] as $pt)
                <option value="{{ $pt->id }}" @selected((string) old('pricing_table_id', $project->pricing_table_id) === (string) $pt->id)>
                    {{ $pt->name }}@if (!$pt->is_active) (inactiva) @endif
                </option>
            @endforeach
        </select>
        @error('pricing_table_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted"><a href="{{ route('admin.pricing-tables.index') }}" target="_blank">Gestionar tablas de precios</a></small>
    </div>
</div>

<div class="form-group">
    <label for="website_url">URL web</label>
    <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url"
        value="{{ old('website_url', $project->website_url) }}">
</div>

<div class="form-group">
    <label for="image">Imagen (ruta)</label>
    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $project->image) }}">
</div>

<div class="form-group">
    <label for="excerpt">Extracto</label>
    <input type="text" class="form-control" id="excerpt" name="excerpt" value="{{ old('excerpt', $project->excerpt) }}">
</div>

<div class="form-group">
    <label for="body">Contenido</label>
    <textarea class="form-control" id="body" name="body" rows="6">{{ old('body', $project->body) }}</textarea>
</div>

<div class="form-group">
    <label for="extra">Extra (JSON opcional)</label>
    <textarea class="form-control @error('extra') is-invalid @enderror" id="extra" name="extra" rows="4">{{ old('extra', $project->extra ? json_encode($project->extra, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancelar</a>

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
                height: 420,
                menubar: 'file edit view insert format tools table help',
                plugins: 'code link lists table image media fullscreen preview searchreplace wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen preview',
                block_formats: 'Parrafo=p; Encabezado 2=h2; Encabezado 3=h3; Encabezado 4=h4; Cita=blockquote',
                branding: false,
                promotion: false,
                relative_urls: false,
                convert_urls: false
            });
        })();
    </script>
@endpush

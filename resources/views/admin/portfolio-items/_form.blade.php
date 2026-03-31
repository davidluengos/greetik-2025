@csrf

<div class="form-group">
    <label for="title">Titulo</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $portfolioItem->title) }}" required>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
            value="{{ old('slug', $portfolioItem->slug) }}">
    </div>
    <div class="form-group col-md-3">
        <label for="menu_order">Orden</label>
        <input type="number" class="form-control" id="menu_order" name="menu_order"
            value="{{ old('menu_order', $portfolioItem->menu_order ?? 0) }}" min="0">
    </div>
    <div class="form-group col-md-3">
        <label for="published_at">Publicacion</label>
        <input type="datetime-local" class="form-control" id="published_at" name="published_at"
            value="{{ old('published_at', optional($portfolioItem->published_at)->format('Y-m-d\TH:i')) }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="category">Categoria</label>
        <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $portfolioItem->category) }}">
        <small class="form-text text-muted">Usada como filtro en la galeria publica (ej. web, app, branding).</small>
    </div>
    <div class="form-group col-md-6">
        <label for="client">Cliente</label>
        <input type="text" class="form-control" id="client" name="client" value="{{ old('client', $portfolioItem->client) }}">
    </div>
</div>

<div class="form-group">
    <label for="completed_at">Fecha de finalizacion</label>
    <input type="date" class="form-control" id="completed_at" name="completed_at"
        value="{{ old('completed_at', optional($portfolioItem->completed_at)->format('Y-m-d')) }}">
</div>

<div class="form-group">
    <label for="image">Imagen (ruta)</label>
    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $portfolioItem->image) }}">
    <small class="form-text text-muted">Puedes pegar una ruta/URL o subir un archivo justo debajo.</small>
</div>

<div class="form-group">
    <label for="image_file">Subir imagen</label>
    <input type="file" class="form-control-file @error('image_file') is-invalid @enderror" id="image_file" name="image_file" accept="image/*">
    @error('image_file')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @if (!empty($portfolioItem->image))
        <small class="form-text text-muted">Imagen actual: {{ $portfolioItem->image }}</small>
    @endif
</div>

<div class="form-group">
    <label for="excerpt">Extracto</label>
    <input type="text" class="form-control" id="excerpt" name="excerpt" value="{{ old('excerpt', $portfolioItem->excerpt) }}">
</div>

<div class="form-group">
    <label for="body">Contenido (pagina de detalle)</label>
    <textarea class="form-control" id="body" name="body" rows="8">{{ old('body', $portfolioItem->body) }}</textarea>
</div>

<div class="form-group">
    <label for="extra">Extra (JSON)</label>
    <textarea class="form-control @error('extra') is-invalid @enderror" id="extra" name="extra" rows="4">{{ old('extra', $portfolioItem->extra ? json_encode($portfolioItem->extra, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $portfolioItem->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.portfolio-items.index') }}" class="btn btn-secondary">Cancelar</a>

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
                height: 360,
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

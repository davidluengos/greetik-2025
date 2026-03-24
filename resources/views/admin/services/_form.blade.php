@csrf

<div class="form-group">
    <label for="title">Titulo</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $service->title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
            value="{{ old('slug', $service->slug) }}">
        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="menu_order">Orden</label>
        <input type="number" class="form-control @error('menu_order') is-invalid @enderror" id="menu_order" name="menu_order"
            value="{{ old('menu_order', $service->menu_order ?? 0) }}" min="0">
    </div>
    <div class="form-group col-md-3">
        <label for="published_at">Publicacion</label>
        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at"
            name="published_at" value="{{ old('published_at', optional($service->published_at)->format('Y-m-d\TH:i')) }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="icon">Icono</label>
        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $service->icon) }}">
    </div>
    <div class="form-group col-md-6">
        <label for="image">Imagen (ruta)</label>
        <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $service->image) }}">
    </div>
</div>

<div class="form-group">
    <label for="excerpt">Extracto</label>
    <input type="text" class="form-control" id="excerpt" name="excerpt" value="{{ old('excerpt', $service->excerpt) }}">
</div>

<div class="form-group">
    <label for="body">Contenido</label>
    <textarea class="form-control" id="body" name="body" rows="6">{{ old('body', $service->body) }}</textarea>
</div>

<div class="form-group">
    <label for="extra">Extra (JSON)</label>
    <textarea class="form-control @error('extra') is-invalid @enderror" id="extra" name="extra" rows="4">{{ old('extra', $service->extra ? json_encode($service->extra, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
    @error('extra')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancelar</a>

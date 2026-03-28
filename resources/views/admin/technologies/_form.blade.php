@csrf

<div class="form-group">
    <label for="title">Titulo</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $technology->title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
            value="{{ old('slug', $technology->slug) }}">
        @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-3">
        <label for="menu_order">Orden</label>
        <input type="number" class="form-control @error('menu_order') is-invalid @enderror" id="menu_order" name="menu_order"
            value="{{ old('menu_order', $technology->menu_order ?? 0) }}" min="0">
    </div>
    <div class="form-group col-md-3 d-flex align-items-end">
        <div class="form-group form-check mb-0">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $technology->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Activa</label>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="image">Imagen (ruta)</label>
        <input type="text" class="form-control" id="image" name="image" placeholder="front/img/technologies/php.png"
            value="{{ old('image', $technology->image) }}">
    </div>
    <div class="form-group col-md-3">
        <label for="icon">Icono (opcional)</label>
        <input type="text" class="form-control" id="icon" name="icon"
            placeholder="fa-brands fa-laravel"
            value="{{ old('icon', $technology->icon) }}">
        <small class="form-text text-muted">Si rellenas esto, se muestra en servicios en lugar de la imagen. Ej.: <code>fa-brands fa-laravel</code>, <code>fa-brands fa-php</code>, <code>fa-solid fa-code</code>.</small>
    </div>
    <div class="form-group col-md-3">
        <label for="badge">Badge (opcional)</label>
        <input type="text" class="form-control @error('badge') is-invalid @enderror" id="badge" name="badge"
            value="{{ old('badge', $technology->badge) }}">
        @error('badge')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="extra">Extra (JSON)</label>
    <textarea class="form-control @error('extra') is-invalid @enderror" id="extra" name="extra" rows="4">{{ old('extra', $technology->extra ? json_encode($technology->extra, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
    @error('extra')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.technologies.index') }}" class="btn btn-secondary">Cancelar</a>

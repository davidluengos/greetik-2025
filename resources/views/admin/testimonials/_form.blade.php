@csrf

<div class="form-row">
    <div class="form-group col-md-8">
        <label for="author">Autor</label>
        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author"
            value="{{ old('author', $testimonial->author) }}" required>
        @error('author')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-4">
        <label for="menu_order">Orden</label>
        <input type="number" class="form-control" id="menu_order" name="menu_order"
            value="{{ old('menu_order', $testimonial->menu_order ?? 0) }}" min="0">
    </div>
</div>

<div class="form-group">
    <label for="role">Cargo / empresa</label>
    <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role"
        value="{{ old('role', $testimonial->role) }}" placeholder="CEO en Empresa S.L.">
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="quote">Opinion</label>
    <textarea class="form-control @error('quote') is-invalid @enderror" id="quote" name="quote" rows="4" required>{{ old('quote', $testimonial->quote) }}</textarea>
    @error('quote')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="photo">Foto (ruta)</label>
    <input type="text" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo"
        value="{{ old('photo', $testimonial->photo) }}" placeholder="front/img/testimonials/cliente.jpg">
    @error('photo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Opcional. Si se deja vacio se muestra un icono generico.</small>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Cancelar</a>

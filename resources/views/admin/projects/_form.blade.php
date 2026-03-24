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
    <label for="extra">Extra (JSON)</label>
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

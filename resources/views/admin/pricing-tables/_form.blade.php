@csrf

<div class="form-group">
    <label for="name">Nombre interno</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        value="{{ old('name', $pricingTable->name) }}" required placeholder="Ej. Planes estandar 3 columnas">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="title">Titulo (front)</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $pricingTable->title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="subtitle">Subtitulo</label>
    <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle"
        value="{{ old('subtitle', $pricingTable->subtitle) }}">
    @error('subtitle')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="plans">Planes (JSON)</label>
    <textarea class="form-control @error('plans') is-invalid @enderror" id="plans" name="plans" rows="14">{{ old('plans', json_encode($pricingTable->plans ?? \App\Support\PricingTables\DefaultPricingPlans::get(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) }}</textarea>
    @error('plans')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">
        Cada plan: <code>name</code>, <code>price</code>, <code>show_price_from</code> (bool; solo si es <code>true</code> se muestra la etiqueta «Desde» encima del precio),
        <code>description</code>, <code>after_features</code> (un string o array de strings; varios párrafos entre características y el botón, clase <code>desc</code>),
        <code>features</code> (array de strings u objetos <code>{&quot;text&quot;,&quot;optional&quot;}</code>),
        <code>highlights</code> (opcional, strings extra arriba), <code>highlighted</code>, <code>button_label</code>, <code>button_url</code>.
        En <code>features</code>, las cadenas que empiecen por <code>(C)</code> son características (se oculta el prefijo); el resto de cadenas van al bloque superior.
        Si ninguna cadena usa <code>(C)</code>, todas las cadenas se muestran como características (listas antiguas).
    </small>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $pricingTable->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activa</label>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.pricing-tables.index') }}" class="btn btn-secondary">Cancelar</a>

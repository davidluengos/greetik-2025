@csrf

<div class="form-group">
    <label for="name">Nombre interno</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        value="{{ old('name', $form->name) }}" required placeholder="Ej. Formulario contacto basico">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Solo para identificarlo en el admin.</small>
</div>

<div class="form-group">
    <label for="title">Titulo (front)</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $form->title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="intro">Introduccion</label>
    <textarea class="form-control @error('intro') is-invalid @enderror" id="intro" name="intro" rows="3">{{ old('intro', $form->intro) }}</textarea>
    @error('intro')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="action_url">URL de envio</label>
        <input type="text" class="form-control @error('action_url') is-invalid @enderror" id="action_url" name="action_url"
            value="{{ old('action_url', $form->action_url ?? '/contacto') }}">
        @error('action_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="button_label">Texto del boton</label>
        <input type="text" class="form-control @error('button_label') is-invalid @enderror" id="button_label" name="button_label"
            value="{{ old('button_label', $form->button_label ?? 'Enviar') }}">
        @error('button_label')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="fields">Campos (JSON)</label>
    <textarea class="form-control @error('fields') is-invalid @enderror" id="fields" name="fields" rows="10">{{ old('fields', json_encode($form->fields ?? \App\Http\Controllers\Admin\ProductFormController::defaultFields(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) }}</textarea>
    @error('fields')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Array de objetos: name, label, type (text, email, tel, textarea), required (bool).</small>
</div>

<div class="form-group form-check">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $form->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.product-forms.index') }}" class="btn btn-secondary">Cancelar</a>

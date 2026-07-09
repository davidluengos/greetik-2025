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
    <textarea class="form-control @error('fields') is-invalid @enderror" id="fields" name="fields" rows="10">{{ old('fields', json_encode($form->fields ?? \App\Support\ProductForms\DefaultProductFormFields::get(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) }}</textarea>
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

<hr>
<h5 class="text-primary">Autorespuesta al usuario</h5>
<p class="text-muted small mb-2">Email automatico que recibe la persona que rellena el formulario (a la direccion de su campo de email).</p>

@php
    $tplFields = is_array($form->fields ?? null) ? $form->fields : \App\Support\ProductForms\DefaultProductFormFields::get();
    $tplTokens = collect($tplFields)
        ->pluck('name')
        ->filter()
        ->map(fn ($n) => '{{ '.$n.' }}')
        ->implode(', ');
@endphp

<div class="form-group form-check">
    <input type="hidden" name="autoresponse_enabled" value="0">
    <input type="checkbox" class="form-check-input" id="autoresponse_enabled" name="autoresponse_enabled" value="1"
        {{ old('autoresponse_enabled', $form->autoresponse_enabled ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="autoresponse_enabled">Enviar autorespuesta al usuario</label>
</div>

<div class="form-group">
    <label for="autoresponse_subject">Asunto</label>
    <input type="text" class="form-control @error('autoresponse_subject') is-invalid @enderror" id="autoresponse_subject" name="autoresponse_subject"
        value="{{ old('autoresponse_subject', $form->autoresponse_subject) }}" placeholder="Hemos recibido tu mensaje">
    @error('autoresponse_subject')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="autoresponse_from_name">Nombre remitente</label>
        <input type="text" class="form-control @error('autoresponse_from_name') is-invalid @enderror" id="autoresponse_from_name" name="autoresponse_from_name"
            value="{{ old('autoresponse_from_name', $form->autoresponse_from_name) }}" placeholder="{{ config('app.name') }}">
        @error('autoresponse_from_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="autoresponse_from_email">Email remitente</label>
        <input type="email" class="form-control @error('autoresponse_from_email') is-invalid @enderror" id="autoresponse_from_email" name="autoresponse_from_email"
            value="{{ old('autoresponse_from_email', $form->autoresponse_from_email) }}" placeholder="{{ config('mail.from.address') }}">
        @error('autoresponse_from_email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">Si se deja vacio se usa el remitente por defecto del sitio.</small>
    </div>
</div>

<div class="form-group">
    <label for="autoresponse_reply_to">Responder-a (Reply-To)</label>
    <input type="email" class="form-control @error('autoresponse_reply_to') is-invalid @enderror" id="autoresponse_reply_to" name="autoresponse_reply_to"
        value="{{ old('autoresponse_reply_to', $form->autoresponse_reply_to) }}" placeholder="hola@tu-dominio.com">
    @error('autoresponse_reply_to')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Direccion a la que llegan las respuestas si el usuario contesta.</small>
</div>

<div class="form-group">
    <label for="autoresponse_body">Cuerpo del email</label>
    <textarea class="form-control @error('autoresponse_body') is-invalid @enderror" id="autoresponse_body" name="autoresponse_body" rows="10">{{ old('autoresponse_body', $form->autoresponse_body) }}</textarea>
    @error('autoresponse_body')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">
        Variables disponibles (asunto y cuerpo): {{ $tplTokens ?: '—' }},
        <code>{{ '{{ site_name }}' }}</code>, <code>{{ '{{ date }}' }}</code>.
    </small>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.product-forms.index') }}" class="btn btn-secondary">Cancelar</a>

@push('scripts')
    @include('admin.partials.tinymce-media-library')
    <script>
        window.initAdminTinyEditorWithMedia('#autoresponse_body', { height: 320 });
    </script>
@endpush

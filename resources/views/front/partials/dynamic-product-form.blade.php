@php
    $idPrefix = $idPrefix ?? 'pf';
    $configuredAction = trim((string) ($formModel->action_url ?? ''));
    $formAction = ($configuredAction !== '' && $configuredAction !== '#') ? $configuredAction : route('contacto.submit');
    $recaptchaEnabled = config('services.recaptcha.enabled');
    $recaptchaSiteKey = config('services.recaptcha.site_key');
    $formInternalName = trim((string) (($formModel ?? null)?->name ?? ''));
    $formTitle = trim((string) (($formModel ?? null)?->title ?? ''));
    if ($formInternalName !== '') {
        $formDisplayLabel = $formInternalName;
        if ($formTitle !== '' && $formTitle !== $formInternalName) {
            $formDisplayLabel .= ' — '.$formTitle;
        }
    } else {
        $formDisplayLabel = $formTitle;
    }
@endphp
@if ($formModel && $formModel->is_active)
    <div class="panel panel-default product-form-block {{ $wrapperClass ?? '' }}">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $formModel->title }}</h3>
        </div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->has('form'))
                <div class="alert alert-danger">{{ $errors->first('form') }}</div>
            @endif
            @if (!empty($formModel->intro))
                <p class="text-muted">{{ $formModel->intro }}</p>
            @endif
            <form action="{{ $formAction }}" method="post" id="{{ $idPrefix }}-dynamic-form">
                @csrf
                <div class="honeypot-field" aria-hidden="true">
                    <label for="{{ $idPrefix }}-website">No rellenar</label>
                    <input type="text" id="{{ $idPrefix }}-website" name="website" value="" tabindex="-1" autocomplete="off">
                </div>
                <input type="hidden" name="form_started_at" value="{{ time() }}">
                <input type="hidden" name="product_form_meta_name" value="{{ $formDisplayLabel }}">
                <input type="hidden" name="product_form_meta_source_url" value="{{ request()->fullUrl() }}">
                @if ($recaptchaEnabled)
                    <input type="hidden" name="g-recaptcha-response" id="{{ $idPrefix }}-g-recaptcha-response" value="">
                @endif
                <div class="row">
                    @foreach (($formModel->fields ?? []) as $field)
                        @php
                            $fieldName = $field['name'] ?? 'field_' . $loop->index;
                            $fieldLabel = $field['label'] ?? ucfirst($fieldName);
                            $fieldType = $field['type'] ?? 'text';
                            $isRequired = !empty($field['required']);
                            $fieldPlaceholder = trim((string) ($field['placeholder'] ?? ''));
                            if ($fieldPlaceholder === '' && $fieldType === 'textarea') {
                                $fieldPlaceholder = 'Cuéntanos brevemente qué necesitas: tipo de proyecto, objetivos, plazos o cualquier duda. Cuanto más nos cuentes, mejor podremos ayudarte.';
                            }
                        @endphp
                        <div class="col-md-{{ in_array($fieldType, ['textarea', 'checkbox'], true) ? '12' : '6' }}">
                            <div class="form-group {{ $fieldType === 'textarea' ? 'form-group-message' : '' }}">
                                @if ($fieldType === 'checkbox')
                                    <div class="checkbox">
                                        <label for="{{ $idPrefix }}-{{ $fieldName }}">
                                            <input
                                                type="checkbox"
                                                id="{{ $idPrefix }}-{{ $fieldName }}"
                                                name="{{ $fieldName }}"
                                                value="1"
                                                {{ old($fieldName) ? 'checked' : '' }}
                                                {{ $isRequired ? 'required' : '' }}>
                                            {{ $fieldLabel }}@if ($isRequired)<span class="required-mark" aria-hidden="true">*</span>@endif
                                        </label>
                                    </div>
                                @else
                                    <label for="{{ $idPrefix }}-{{ $fieldName }}">{{ $fieldLabel }}@if ($isRequired)<span class="required-mark" aria-hidden="true">*</span>@endif</label>
                                @endif
                                @if ($fieldType === 'textarea')
                                    <textarea
                                        class="form-control"
                                        id="{{ $idPrefix }}-{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        rows="4"
                                        @if ($fieldPlaceholder !== '') placeholder="{{ $fieldPlaceholder }}" @endif
                                        {{ $isRequired ? 'required' : '' }}>{{ old($fieldName) }}</textarea>
                                @elseif ($fieldType === 'checkbox')
                                    {{-- checkbox already rendered above --}}
                                @else
                                    <input
                                        type="{{ in_array($fieldType, ['text', 'email', 'tel', 'number'], true) ? $fieldType : 'text' }}"
                                        class="form-control"
                                        id="{{ $idPrefix }}-{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        value="{{ old($fieldName) }}"
                                        @if ($fieldPlaceholder !== '') placeholder="{{ $fieldPlaceholder }}" @endif
                                        {{ $isRequired ? 'required' : '' }}>
                                @endif
                                @error($fieldName)
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">{{ $formModel->button_label ?: 'Enviar' }}</button>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            (function () {
                var form = document.getElementById('{{ $idPrefix }}-dynamic-form');
                if (!form) {
                    return;
                }
                form.addEventListener('submit', function () {
                    var urlInput = form.querySelector('input[name="product_form_meta_source_url"]');
                    if (urlInput) {
                        urlInput.value = window.location.href;
                    }
                });
            })();
        </script>
    @endpush
@endif

@if ($recaptchaEnabled && !empty($recaptchaSiteKey))
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
        <script>
            (function () {
                var form = document.getElementById('{{ $idPrefix }}-dynamic-form');
                var tokenInput = document.getElementById('{{ $idPrefix }}-g-recaptcha-response');
                if (!form || !tokenInput || typeof grecaptcha === 'undefined') {
                    return;
                }

                form.addEventListener('submit', function (event) {
                    if (tokenInput.value) {
                        return;
                    }

                    event.preventDefault();
                    grecaptcha.ready(function () {
                        grecaptcha.execute('{{ $recaptchaSiteKey }}', {action: 'contact_form'}).then(function (token) {
                            tokenInput.value = token;
                            form.submit();
                        });
                    });
                });
            })();
        </script>
    @endpush
@endif

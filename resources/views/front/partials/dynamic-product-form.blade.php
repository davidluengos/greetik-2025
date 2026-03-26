@php
    $idPrefix = $idPrefix ?? 'pf';
@endphp
@if ($formModel && $formModel->is_active)
    <div class="panel panel-default product-form-block {{ $wrapperClass ?? '' }}">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $formModel->title }}</h3>
        </div>
        <div class="panel-body">
            @if (!empty($formModel->intro))
                <p class="text-muted">{{ $formModel->intro }}</p>
            @endif
            <form action="{{ $formModel->action_url ?: '/contacto' }}" method="post">
                @csrf
                <div class="row">
                    @foreach (($formModel->fields ?? []) as $field)
                        @php
                            $fieldName = $field['name'] ?? 'field_' . $loop->index;
                            $fieldLabel = $field['label'] ?? ucfirst($fieldName);
                            $fieldType = $field['type'] ?? 'text';
                            $isRequired = !empty($field['required']);
                        @endphp
                        <div class="col-md-{{ $fieldType === 'textarea' ? '12' : '6' }}">
                            <div class="form-group">
                                <label for="{{ $idPrefix }}-{{ $fieldName }}">{{ $fieldLabel }}</label>
                                @if ($fieldType === 'textarea')
                                    <textarea
                                        class="form-control"
                                        id="{{ $idPrefix }}-{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        rows="4"
                                        {{ $isRequired ? 'required' : '' }}></textarea>
                                @else
                                    <input
                                        type="{{ in_array($fieldType, ['text', 'email', 'tel', 'number'], true) ? $fieldType : 'text' }}"
                                        class="form-control"
                                        id="{{ $idPrefix }}-{{ $fieldName }}"
                                        name="{{ $fieldName }}"
                                        {{ $isRequired ? 'required' : '' }}>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">{{ $formModel->button_label ?: 'Enviar' }}</button>
            </form>
        </div>
    </div>
@endif

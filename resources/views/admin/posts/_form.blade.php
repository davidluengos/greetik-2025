@csrf
@php
    $defaultPublishAt = old('publishdate', optional($post->publishdate)->format('Y-m-d\TH:i'));
    if (!$defaultPublishAt && !$post->exists) {
        $defaultPublishAt = now()->format('Y-m-d\TH:i');
    }
@endphp

<div class="form-group">
    <label for="title">Titulo</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $post->title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="tags">Tags (separadas por coma)</label>
    <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags"
        value="{{ old('tags', $post->tags) }}" autocomplete="off" list="tags-datalist">
    <datalist id="tags-datalist">
        @foreach (($tagSuggestions ?? []) as $tagSuggestion)
            <option value="{{ $tagSuggestion }}"></option>
        @endforeach
    </datalist>
    <small id="tags-help" class="form-text text-muted">Escribe y se sugeriran tags existentes.</small>
    <div id="tags-suggestions" class="list-group mt-2" style="display:none; max-height: 180px; overflow-y: auto;"></div>
    <script id="tags-suggestions-data" type="application/json">{!! json_encode($tagSuggestions ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @error('tags')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="metatitle">Meta title</label>
    <input type="text" class="form-control" id="metatitle" name="metatitle"
        value="{{ old('metatitle', $post->metatitle) }}">
    <small id="metatitle-counter" class="form-text text-muted">0/60</small>
</div>

<div class="form-group">
    <label for="metadescription">Meta description</label>
    <input type="text" class="form-control" id="metadescription" name="metadescription"
        value="{{ old('metadescription', $post->metadescription) }}">
    <div class="d-flex justify-content-between align-items-center mt-1">
        <small id="metadescription-counter" class="form-text text-muted mb-0">0/160</small>
        <button type="button" id="generate-meta-ai" class="btn btn-outline-primary btn-sm">Generar con IA</button>
    </div>
    <small id="metadescription-ai-status" class="form-text text-muted"></small>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="publishdate">Fecha publicacion</label>
        <input type="datetime-local" class="form-control @error('publishdate') is-invalid @enderror" id="publishdate"
            name="publishdate" value="{{ $defaultPublishAt }}">
    </div>
    <div class="form-group col-md-6">
        <label for="enddate">Fecha fin</label>
        <input type="datetime-local" class="form-control @error('enddate') is-invalid @enderror" id="enddate"
            name="enddate" value="{{ old('enddate', optional($post->enddate)->format('Y-m-d\TH:i')) }}">
    </div>
</div>

<div class="form-group">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-1">
        <label for="body" class="mb-0">Contenido</label>
        <a href="{{ route('admin.site-media.index') }}" target="_blank" rel="noopener" class="small">Biblioteca multimedia</a>
    </div>
    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="10">{{ old('body', $post->body) }}</textarea>
    @error('body')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Usa el botón <strong>Medios</strong> en la barra del editor, o en el dialogo de imagen el botón de explorar archivos, para elegir una foto de la biblioteca. También puedes copiar la URL desde la página Medios del panel.</small>
</div>

<div class="form-group">
    <label for="extra">Extra</label>
    <textarea class="form-control" id="extra" name="extra" rows="4">{{ old('extra', $post->extra) }}</textarea>
</div>

<button class="btn btn-primary" type="submit">Guardar</button>
<a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancelar</a>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        (function () {
            if (typeof tinymce === 'undefined') {
                return;
            }

            var pickerItemsUrl = @json(route('admin.site-media.picker-items'));
            var mediaIndexUrl = @json(route('admin.site-media.index'));

            function escapeHtmlAttr(value) {
                return String(value ?? '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
            }

            /** Abre la biblioteca en un dialogo de TinyMCE (misma capa UI que el editor, sin modal Bootstrap). */
            function openSiteMediaLibrary(editor, pickerCallback) {
                var hostId = 'site-media-host-' + Date.now();
                var emptyId = 'site-media-empty-' + Date.now();

                var dialogApi = editor.windowManager.open({
                    title: 'Biblioteca multimedia',
                    size: 'large',
                    body: {
                        type: 'panel',
                        items: [{
                            type: 'htmlpanel',
                            html: '<div id="' + hostId + '" style="min-height:260px;max-height:52vh;overflow:auto;width:100%;box-sizing:border-box;"></div>' +
                                '<p id="' + emptyId + '" style="display:none;margin:10px 0;color:#64748b;">No hay imágenes. Sube archivos en Medios del panel.</p>' +
                                '<p style="margin:0;font-size:12px;color:#64748b;"><a href="' + escapeHtmlAttr(mediaIndexUrl) + '" target="_blank" rel="noopener">Abrir página Medios</a></p>'
                        }]
                    },
                    buttons: [
                        { type: 'cancel', text: 'Cerrar' }
                    ]
                });

                var attempts = 0;

                function tryFill() {
                    var host = document.getElementById(hostId) || document.querySelector('.tox-dialog [id="' + hostId + '"]');
                    var emptyEl = document.getElementById(emptyId) || document.querySelector('.tox-dialog [id="' + emptyId + '"]');
                    if (!host && attempts < 25) {
                        attempts += 1;
                        window.setTimeout(tryFill, 40);
                        return;
                    }
                    if (!host) {
                        return;
                    }

                    host.textContent = 'Cargando...';

                    fetch(pickerItemsUrl + '?images_only=1', {
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        host.innerHTML = '';
                        var items = data.items || [];
                        if (!items.length) {
                            if (emptyEl) {
                                emptyEl.style.display = 'block';
                            }
                            return;
                        }

                        var wrap = document.createElement('div');
                        wrap.style.display = 'flex';
                        wrap.style.flexWrap = 'wrap';
                        wrap.style.gap = '10px';
                        wrap.style.alignItems = 'stretch';
                        wrap.style.justifyContent = 'flex-start';

                        items.forEach(function (it) {
                            var btn = document.createElement('button');
                            btn.type = 'button';
                            btn.style.cssText = 'margin:0;padding:6px;border:1px solid #cbd5e1;border-radius:6px;background:#fff;cursor:pointer;flex:1 1 120px;max-width:180px;min-width:96px;box-sizing:border-box;display:flex;align-items:center;justify-content:center;';
                            var img = document.createElement('img');
                            img.src = it.url;
                            img.alt = '';
                            img.loading = 'lazy';
                            img.style.cssText = 'max-width:100%;max-height:120px;height:auto;object-fit:contain;display:block;';
                            btn.appendChild(img);
                            btn.addEventListener('click', function () {
                                var alt = it.title || '';
                                if (typeof pickerCallback === 'function') {
                                    pickerCallback(it.url, { alt: alt, title: alt });
                                } else {
                                    editor.insertContent('<img src="' + escapeHtmlAttr(it.url) + '" alt="' + escapeHtmlAttr(alt) + '" />');
                                }
                                dialogApi.close();
                            });
                            wrap.appendChild(btn);
                        });

                        host.appendChild(wrap);
                    }).catch(function () {
                        host.innerHTML = '';
                        var err = document.createElement('p');
                        err.style.color = '#b91c1c';
                        err.style.margin = '0';
                        err.textContent = 'No se pudo cargar la biblioteca.';
                        host.appendChild(err);
                    });
                }

                window.setTimeout(tryFill, 0);
            }

            var postBodyEditor = null;

            tinymce.remove('#body');
            tinymce.init({
                selector: '#body',
                height: 520,
                menubar: 'file edit view insert format tools table help',
                plugins: 'code link lists table image media fullscreen preview searchreplace wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | sitemediagallery | link image media table | code fullscreen preview',
                block_formats: 'Parrafo=p; Encabezado 2=h2; Encabezado 3=h3; Encabezado 4=h4; Cita=blockquote',
                branding: false,
                promotion: false,
                relative_urls: false,
                convert_urls: false,
                file_picker_types: 'image',
                file_picker_callback: function (callback, value, meta) {
                    if (meta.filetype !== 'image') {
                        return;
                    }
                    if (!postBodyEditor) {
                        return;
                    }
                    openSiteMediaLibrary(postBodyEditor, callback);
                },
                setup: function (editor) {
                    postBodyEditor = editor;

                    editor.ui.registry.addButton('sitemediagallery', {
                        text: 'Medios',
                        tooltip: 'Insertar imagen desde la biblioteca multimedia',
                        onAction: function () {
                            openSiteMediaLibrary(editor, null);
                        }
                    });

                    editor.on('keyup change input', function () {
                        if (typeof window.__refreshMetaFromBody === 'function') {
                            window.__refreshMetaFromBody();
                        }
                    });
                }
            });
        })();

        (function () {
            const titleInput = document.getElementById('title');
            const bodyTextarea = document.getElementById('body');
            const metaTitleInput = document.getElementById('metatitle');
            const metaDescriptionInput = document.getElementById('metadescription');
            const metaTitleCounter = document.getElementById('metatitle-counter');
            const metaDescriptionCounter = document.getElementById('metadescription-counter');

            if (!titleInput || !metaTitleInput || !metaDescriptionInput || !metaTitleCounter || !metaDescriptionCounter) {
                return;
            }

            let metaTitleTouched = metaTitleInput.value.trim().length > 0;
            let metaDescriptionTouched = metaDescriptionInput.value.trim().length > 0;

            const setCounterColor = (node, length, min, max) => {
                node.classList.remove('text-success', 'text-warning', 'text-danger', 'text-muted');
                if (length === 0) {
                    node.classList.add('text-muted');
                    return;
                }
                if (length < min) {
                    node.classList.add('text-warning');
                    return;
                }
                if (length > max) {
                    node.classList.add('text-danger');
                    return;
                }
                node.classList.add('text-success');
            };

            const updateCounters = () => {
                const titleLength = metaTitleInput.value.trim().length;
                const descriptionLength = metaDescriptionInput.value.trim().length;
                metaTitleCounter.textContent = `${titleLength}/60`;
                metaDescriptionCounter.textContent = `${descriptionLength}/160`;
                setCounterColor(metaTitleCounter, titleLength, 45, 60);
                setCounterColor(metaDescriptionCounter, descriptionLength, 120, 160);
            };

            const truncate = (text, max) => {
                if (text.length <= max) {
                    return text;
                }
                return text.slice(0, max).trim();
            };

            const plainText = (html) => {
                const temp = document.createElement('div');
                temp.innerHTML = html || '';
                return (temp.textContent || temp.innerText || '').replace(/\s+/g, ' ').trim();
            };

            const buildMetaDescription = () => {
                let source = '';

                if (typeof tinymce !== 'undefined' && tinymce.get('body')) {
                    source = plainText(tinymce.get('body').getContent());
                } else if (bodyTextarea) {
                    source = plainText(bodyTextarea.value);
                }

                if (!source) {
                    source = titleInput.value.trim();
                }

                return truncate(source, 160);
            };

            const refreshMetaTitle = () => {
                if (metaTitleTouched) {
                    return;
                }
                metaTitleInput.value = truncate(titleInput.value.trim(), 60);
                updateCounters();
            };

            const refreshMetaDescription = () => {
                if (metaDescriptionTouched) {
                    return;
                }
                metaDescriptionInput.value = buildMetaDescription();
                updateCounters();
            };

            window.__refreshMetaFromBody = refreshMetaDescription;

            titleInput.addEventListener('input', () => {
                refreshMetaTitle();
                refreshMetaDescription();
            });

            if (bodyTextarea) {
                bodyTextarea.addEventListener('input', refreshMetaDescription);
            }

            metaTitleInput.addEventListener('input', () => {
                metaTitleTouched = true;
                updateCounters();
            });

            metaDescriptionInput.addEventListener('input', () => {
                metaDescriptionTouched = true;
                updateCounters();
            });

            updateCounters();
            refreshMetaTitle();
            refreshMetaDescription();
        })();

        (function () {
            const button = document.getElementById('generate-meta-ai');
            const status = document.getElementById('metadescription-ai-status');
            const titleInput = document.getElementById('title');
            const tagsInput = document.getElementById('tags');
            const descriptionInput = document.getElementById('metadescription');
            const bodyTextarea = document.getElementById('body');

            if (!button || !status || !descriptionInput) {
                return;
            }

            const setStatus = (text, css = 'text-muted') => {
                status.classList.remove('text-muted', 'text-success', 'text-danger');
                status.classList.add(css);
                status.textContent = text;
            };

            button.addEventListener('click', async () => {
                button.disabled = true;
                setStatus('Generando descripción con IA...', 'text-muted');

                let bodyContent = '';
                if (typeof tinymce !== 'undefined' && tinymce.get('body')) {
                    bodyContent = tinymce.get('body').getContent();
                } else if (bodyTextarea) {
                    bodyContent = bodyTextarea.value;
                }

                try {
                    const response = await fetch("{{ route('admin.posts.meta-description-ai') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            title: titleInput ? titleInput.value : '',
                            tags: tagsInput ? tagsInput.value : '',
                            body: bodyContent
                        })
                    });

                    const contentType = response.headers.get('content-type') || '';
                    let data = {};
                    if (contentType.includes('application/json')) {
                        data = await response.json();
                    } else {
                        data = { message: await response.text() };
                    }

                    if (!response.ok) {
                        throw new Error(data.error || data.message || 'Error al generar');
                    }

                    descriptionInput.value = data.metadescription || '';
                    descriptionInput.dispatchEvent(new Event('input', { bubbles: true }));
                    setStatus('Descripción generada con IA.', 'text-success');
                } catch (error) {
                    setStatus(error.message || 'No se pudo generar con IA.', 'text-danger');
                } finally {
                    button.disabled = false;
                }
            });
        })();

        (function () {
            const input = document.getElementById('tags');
            const box = document.getElementById('tags-suggestions');
            const dataNode = document.getElementById('tags-suggestions-data');
            let allTags = [];

            try {
                allTags = dataNode ? JSON.parse(dataNode.textContent || '[]') : [];
            } catch (error) {
                allTags = [];
            }

            if (!input || !box || !Array.isArray(allTags)) {
                return;
            }

            const normalize = (value) => (value || '').trim().toLowerCase();

            const currentToken = () => {
                const parts = input.value.split(',');
                return (parts[parts.length - 1] || '').trim();
            };

            const selectedTags = () => {
                return input.value
                    .split(',')
                    .map((item) => normalize(item))
                    .filter((item) => item.length > 0);
            };

            const hide = () => {
                box.style.display = 'none';
                box.innerHTML = '';
            };

            const applySuggestion = (tag) => {
                const parts = input.value.split(',').map((item) => item.trim());
                parts[parts.length - 1] = tag;
                const cleaned = parts.filter((item) => item.length > 0);
                input.value = cleaned.join(', ') + ', ';
                hide();
                input.focus();
            };

            input.addEventListener('input', () => {
                const token = normalize(currentToken());
                const selected = new Set(selectedTags());

                if (!token) {
                    hide();
                    return;
                }

                const matches = allTags
                    .filter((tag) => normalize(tag).includes(token))
                    .filter((tag) => !selected.has(normalize(tag)))
                    .slice(0, 8);

                if (matches.length === 0) {
                    hide();
                    return;
                }

                box.innerHTML = '';
                matches.forEach((tag) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'list-group-item list-group-item-action py-1';
                    button.textContent = tag;
                    button.addEventListener('click', () => applySuggestion(tag));
                    box.appendChild(button);
                });

                box.style.display = 'block';
            });

            document.addEventListener('click', (event) => {
                if (!box.contains(event.target) && event.target !== input) {
                    hide();
                }
            });
        })();
    </script>
@endpush

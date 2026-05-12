<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    (function () {
        if (window.__adminTinyMediaReady) {
            return;
        }
        window.__adminTinyMediaReady = true;

        var pickerItemsUrl = "{{ route('admin.site-media.picker-items') }}";
        var mediaIndexUrl = "{{ route('admin.site-media.index') }}";

        function escapeHtmlAttr(value) {
            return String(value === null || typeof value === 'undefined' ? '' : value)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;');
        }

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
                buttons: [{ type: 'cancel', text: 'Cerrar' }]
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

        window.initAdminTinyEditorWithMedia = function (selector, options) {
            if (typeof tinymce === 'undefined') {
                return;
            }

            var editorRef = null;
            var extraOptions = options || {};
            var resolvedSelector = selector || '#body';

            tinymce.remove(resolvedSelector);
            tinymce.init(Object.assign({
                selector: resolvedSelector,
                height: 420,
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
                    if (meta.filetype !== 'image' || !editorRef) {
                        return;
                    }
                    openSiteMediaLibrary(editorRef, callback);
                },
                setup: function (editor) {
                    editorRef = editor;
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
                    if (typeof extraOptions.setup === 'function') {
                        extraOptions.setup(editor);
                    }
                }
            }, extraOptions));
        };
    })();
</script>

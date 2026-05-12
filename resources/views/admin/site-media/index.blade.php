@extends('admin.layouts.app')

@section('title', 'Biblioteca multimedia - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="h3 mb-0 text-gray-800">Biblioteca multimedia</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Subir archivos</h6>
        </div>
        <div class="card-body">
            <p class="text-muted small mb-3">
                Las imágenes y otros archivos quedan en <code>storage/site-media</code> y se sirven como URL pública
                (por ejemplo para insertarlas en posts con el selector del editor o copiando el enlace).
            </p>
            <form action="{{ route('admin.site-media.store') }}" method="POST" enctype="multipart/form-data" class="mb-0">
                @csrf
                <div class="form-group">
                    <label for="files">Archivos (varios a la vez)</label>
                    <input type="file" name="files[]" id="files" class="form-control-file @error('files') is-invalid @enderror @error('files.*') is-invalid @enderror" multiple required accept="image/*,video/*,audio/*,.svg">
                    @error('files')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('files.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Subir</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Archivos subidos</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse ($mediaItems as $item)
                    <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card h-100 border-left-primary shadow-sm">
                            <div class="card-body p-2">
                                <div class="mb-2 text-center bg-light rounded" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">
                                    @if ($item->isImage())
                                        <img src="{{ $item->publicUrl() }}" alt="" class="img-fluid" style="max-height: 140px; object-fit: contain;">
                                    @elseif (str_starts_with((string) $item->mime_type, 'video/'))
                                        <video src="{{ $item->publicUrl() }}" controls class="w-100" style="max-height: 160px;"></video>
                                    @else
                                        <i class="fas fa-file-audio fa-3x text-secondary"></i>
                                    @endif
                                </div>
                                <p class="small text-truncate mb-1" title="{{ $item->original_filename }}">{{ $item->original_filename }}</p>
                                <div class="input-group input-group-sm mb-2">
                                    <input type="text" class="form-control site-media-url-field" readonly value="{{ $item->publicUrl() }}" id="url-{{ $item->id }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary site-media-copy" data-target="#url-{{ $item->id }}" title="Copiar URL">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <form action="{{ route('admin.site-media.update', $item) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="small text-muted mb-0" for="alt-{{ $item->id }}">Texto alternativo (imágenes)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="alt_text" id="alt-{{ $item->id }}" value="{{ old('alt_text', $item->alt_text) }}" maxlength="500" placeholder="Opcional">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-primary">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="{{ route('admin.site-media.destroy', $item) }}" method="POST" onsubmit="return confirm('Eliminar este archivo del servidor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-block">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted mb-0">Todavía no hay archivos. Sube el primero arriba.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-2">
                {{ $mediaItems->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            document.querySelectorAll('.site-media-copy').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var sel = btn.getAttribute('data-target');
                    var input = document.querySelector(sel);
                    if (!input) {
                        return;
                    }
                    input.select();
                    input.setSelectionRange(0, 99999);
                    var text = input.value;
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(function () {
                            btn.classList.remove('btn-outline-secondary');
                            btn.classList.add('btn-success');
                            setTimeout(function () {
                                btn.classList.add('btn-outline-secondary');
                                btn.classList.remove('btn-success');
                            }, 1200);
                        });
                    } else {
                        try {
                            document.execCommand('copy');
                        } catch (e) {}
                    }
                });
            });
        })();
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Paginas del sitio')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Paginas del sitio</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <p class="text-muted small mb-3">
                Contenido estatico del sitio: corporativo, contacto y <strong>textos legales</strong>
                (aviso legal, privacidad, cookies, terminos). Las URLs coinciden con el <code>slug</code> de cada fila
                (p. ej. <code>/aviso-legal</code>, <code>/politica-de-privacidad</code>).
            </p>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Slug</th>
                            <th>Titulo</th>
                            <th>Activa</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $p)
                            <tr>
                                <td><code>{{ $p->slug }}</code></td>
                                <td>{{ $p->title }}</td>
                                <td>{{ $p->is_active ? 'Si' : 'No' }}</td>
                                <td class="text-center">
                                    @if ($url = $p->publicUrl())
                                        <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm">Ver</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.site-pages.edit', $p) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pen"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

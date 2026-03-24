@extends('admin.layouts.app')

@section('title', 'Posts - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">Nuevo post</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Tags</th>
                        <th>Publicacion</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>
                                @forelse ($post->tags_array as $tag)
                                    <span class="badge badge-pill badge-info mr-1 mb-1">{{ $tag }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td>{{ optional($post->publishdate)->format('d/m/Y H:i') }}</td>
                            <td class="text-right text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.posts.show', $post) }}" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.posts.edit', $post) }}" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Borrar" onclick="return confirm('Eliminar post?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Sin registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
@endsection

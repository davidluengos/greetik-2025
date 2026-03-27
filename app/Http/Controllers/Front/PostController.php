<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->orderByDesc('createdat')
            ->paginate(10)
            ->withQueryString();

        return view('front.posts', compact('posts'));
    }

    public function show($slug)
    {
        // Separar el ID del final del slug
        $lastHyphenPos = strrpos($slug, '-');
        if ($lastHyphenPos === false) {
            abort(404); // No hay guion
        }

        $id = substr($slug, $lastHyphenPos + 1);
        $titleSlug = substr($slug, 0, $lastHyphenPos);

        if (!is_numeric($id)) {
            abort(404); // ID inválido
        }

        $post = Post::findOrFail($id);

        // Redirigir si el slug no coincide con el título real
        if ($titleSlug !== Str::slug($post->title)) {
            return redirect('/post/' . Str::slug($post->title) . '-' . $post->id);
        }

        return view('front.post', compact('post'));
    }
}

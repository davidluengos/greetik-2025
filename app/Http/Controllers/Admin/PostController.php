<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GeneratePostMetaDescriptionRequest;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Post;
use App\Services\Posts\PostTagService;
use App\Services\Seo\OpenAiMetaDescriptionGenerator;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $posts = Post::orderByDesc('createdat')->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(PostTagService $postTagService)
    {
        $post = new Post();
        $tagSuggestions = $postTagService->suggestions();

        return view('admin.posts.create', compact('post', 'tagSuggestions'));
    }

    public function store(StorePostRequest $request, PostTagService $postTagService)
    {
        $data = $this->validatedData($request->validated(), $postTagService);
        $data['user'] = Auth::id();

        Post::create($data);
        $postTagService->syncRepetitions();

        return redirect()->route('admin.posts.index')->with('status', 'Post creado correctamente.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post, PostTagService $postTagService)
    {
        $tagSuggestions = $postTagService->suggestions();

        return view('admin.posts.edit', compact('post', 'tagSuggestions'));
    }

    public function update(UpdatePostRequest $request, Post $post, PostTagService $postTagService)
    {
        $data = $this->validatedData($request->validated(), $postTagService);
        if (Auth::check()) {
            $data['user'] = Auth::id();
        }

        $post->update($data);
        $postTagService->syncRepetitions();

        return redirect()->route('admin.posts.index')->with('status', 'Post actualizado correctamente.');
    }

    public function destroy(Post $post, PostTagService $postTagService)
    {
        $post->delete();
        $postTagService->syncRepetitions();

        return redirect()->route('admin.posts.index')->with('status', 'Post eliminado.');
    }

    public function generateMetaDescriptionAi(GeneratePostMetaDescriptionRequest $request, OpenAiMetaDescriptionGenerator $generator)
    {
        $payload = $request->validated();

        try {
            $text = $generator->generate(
                (string) ($payload['title'] ?? ''),
                (string) ($payload['tags'] ?? ''),
                (string) ($payload['body'] ?? '')
            );
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], max(400, $exception->getCode()));
        }

        return response()->json(['metadescription' => $text]);
    }

    private function validatedData(array $data, PostTagService $postTagService): array
    {
        $data['tags'] = $postTagService->normalize((string) ($data['tags'] ?? ''));

        return $data;
    }
}

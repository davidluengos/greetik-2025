<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderByDesc('createdat')->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post();
        $tagSuggestions = Tag::query()
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->pluck('name')
            ->unique()
            ->values()
            ->all();

        return view('admin.posts.create', compact('post', 'tagSuggestions'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['user'] = Auth::id();

        Post::create($data);
        $this->syncTagRepetitions();

        return redirect()->route('admin.posts.index')->with('status', 'Post creado correctamente.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $tagSuggestions = Tag::query()
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->pluck('name')
            ->unique()
            ->values()
            ->all();

        return view('admin.posts.edit', compact('post', 'tagSuggestions'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validatedData($request);
        if (Auth::check()) {
            $data['user'] = Auth::id();
        }

        $post->update($data);
        $this->syncTagRepetitions();

        return redirect()->route('admin.posts.index')->with('status', 'Post actualizado correctamente.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        $this->syncTagRepetitions();

        return redirect()->route('admin.posts.index')->with('status', 'Post eliminado.');
    }

    public function generateMetaDescriptionAi(Request $request)
    {
        $payload = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
        ]);

        $apiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');
        if (!$apiKey) {
            return response()->json([
                'message' => 'OPENAI_API_KEY no configurada. Añadela en el .env para generar con IA.',
            ], 422);
        }

        $title = trim((string) ($payload['title'] ?? ''));
        $tags = trim((string) ($payload['tags'] ?? ''));
        $body = trim(strip_tags((string) ($payload['body'] ?? '')));
        $body = Str::limit(preg_replace('/\s+/', ' ', $body) ?: '', 1400, '');

        if ($title === '' && $body === '') {
            return response()->json(['message' => 'Faltan datos para generar la meta description.'], 422);
        }

        $model = env('OPENAI_MODEL', 'gpt-4o-mini');
        $prompt = "Genera una metadescription SEO en español (140-160 caracteres), clara, natural y sin comillas.\n"
            . "Devuelve SOLO una frase final.\n\n"
            . "Título: {$title}\n"
            . "Tags: {$tags}\n"
            . "Contenido: {$body}";

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => $model,
                    'input' => $prompt,
                    'temperature' => 0.4,
                    'max_output_tokens' => 120,
                ]);
        } catch (Throwable $exception) {
            logger()->error('OpenAI request failed', [
                'message' => $exception->getMessage(),
                'class' => get_class($exception),
            ]);

            return response()->json([
                'message' => 'Error de conexión con OpenAI.',
                'error' => $exception->getMessage(),
            ], 500);
        }

        if (!$response->ok()) {
            $apiError = $response->json('error.message') ?: $response->body();
            logger()->warning('OpenAI non-ok response', [
                'status' => $response->status(),
                'body' => $response->json() ?: $response->body(),
            ]);

            return response()->json([
                'message' => is_string($apiError) && trim($apiError) !== ''
                    ? $apiError
                    : 'No se pudo generar la descripción con IA.',
                'error' => $apiError,
            ], $response->status());
        }

        $json = $response->json();
        $text = (string) ($json['output_text'] ?? '');

        if ($text === '' && isset($json['output']) && is_array($json['output'])) {
            $chunks = [];
            foreach ($json['output'] as $item) {
                if (!isset($item['content']) || !is_array($item['content'])) {
                    continue;
                }

                foreach ($item['content'] as $contentItem) {
                    $candidate = $contentItem['text']
                        ?? $contentItem['output_text']
                        ?? $contentItem['value']
                        ?? '';

                    if (is_string($candidate) && trim($candidate) !== '') {
                        $chunks[] = $candidate;
                    }
                }
            }
            $text = implode(' ', $chunks);
        }

        $text = trim(preg_replace('/\s+/', ' ', $text) ?: '');
        $text = trim($text, "\"' \t\n\r\0\x0B");
        $text = Str::limit($text, 160, '');

        if ($text === '') {
            logger()->warning('OpenAI empty meta-description response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            return response()->json(['message' => 'La IA no devolvio una descripción valida.'], 500);
        }

        return response()->json(['metadescription' => $text]);
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:255'],
            'metatitle' => ['nullable', 'string', 'max:255'],
            'metadescription' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'publishdate' => ['nullable', 'date'],
            'enddate' => ['nullable', 'date', 'after_or_equal:publishdate'],
            'extra' => ['nullable', 'string'],
        ]);

        $data['tags'] = $this->normalizeTags($data['tags'] ?? '');

        return $data;
    }

    private function normalizeTags(string $tags): string
    {
        return collect(explode(',', $tags))
            ->map(static fn (string $tag) => trim($tag))
            ->filter()
            ->map(static fn (string $tag) => Str::lower($tag))
            ->unique()
            ->implode(', ');
    }

    private function syncTagRepetitions(): void
    {
        $counts = [];

        Post::query()->select(['tags'])->chunk(200, function ($posts) use (&$counts): void {
            foreach ($posts as $post) {
                foreach ($post->tags_array as $tagName) {
                    $normalized = Str::lower(trim($tagName));
                    if ($normalized === '') {
                        continue;
                    }

                    // Prefix avoids PHP casting numeric string keys (e.g. "2019") to integers.
                    $internalKey = '__' . $normalized;
                    $counts[$internalKey] = ($counts[$internalKey] ?? 0) + 1;
                }
            }
        });

        foreach ($counts as $internalKey => $repetitions) {
            $name = substr((string) $internalKey, 2);
            Tag::query()->updateOrCreate(
                ['name' => $name, 'project' => 0],
                ['repetitions' => $repetitions]
            );
        }

        // Legacy-safe reset: avoids NOT IN issues with large string lists in some MySQL setups.
        Tag::query()->update(['repetitions' => 0]);

        foreach ($counts as $internalKey => $repetitions) {
            $name = substr((string) $internalKey, 2);
            Tag::query()
                ->where('name', $name)
                ->where('project', 0)
                ->update(['repetitions' => $repetitions]);
        }
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class LegacyRedirectController extends Controller
{
    /** Ratio mínimo de tokens compartidos entre URL slug y post slug para aceptar auto-fallback. */
    private const POST_SLUG_MATCH_MIN_RATIO = 0.5;

    public function handle(string $path): RedirectResponse
    {
        if (! preg_match('/-(\d+)$/', $path, $matches)) {
            $this->logMiss($path, 'no-id-in-path');
            abort(410);
        }

        $oldId = (int) $matches[1];

        $mapping = config('legacy_redirects.'.$oldId);
        if (is_array($mapping)) {
            $target = $this->resolveMappedTarget($mapping);
            if ($target !== null) {
                return redirect()->away($target, 301);
            }
        }

        // Auto-fallback a blog post: si no hay mapping explícito pero old_id coincide
        // con un Post existente Y el slug de la URL antigua se parece al slug del post,
        // asumimos que era un post. El slug-check protege de colisiones tipo section 40
        // (MyTrainik como Project) donde post.id=40 tambien existe pero es otro contenido.
        $post = Post::find($oldId);
        if ($post !== null && $this->pathSlugMatchesPost($path, $post)) {
            return redirect(url('/post/'.Str::slug($post->title).'-'.$post->id), 301);
        }

        $this->logMiss($path, 'no-mapping', $oldId);
        abort(410);
    }

    private function pathSlugMatchesPost(string $path, Post $post): bool
    {
        $lastDash = strrpos($path, '-');
        if ($lastDash === false) {
            return false;
        }

        $pathSlug = Str::slug(substr($path, 0, $lastDash));
        $postSlug = Str::slug($post->title);

        $pathTokens = array_values(array_filter(explode('-', $pathSlug)));
        $postTokens = array_values(array_filter(explode('-', $postSlug)));

        if ($pathTokens === [] || $postTokens === []) {
            return false;
        }

        $common = array_intersect($pathTokens, $postTokens);
        return count($common) / count($pathTokens) >= self::POST_SLUG_MATCH_MIN_RATIO;
    }

    private function resolveMappedTarget(array $mapping): ?string
    {
        $type = $mapping['type'] ?? null;

        if ($type === 'url' && is_string($mapping['url'] ?? null)) {
            return $mapping['url'];
        }

        if ($type === 'route' && is_string($mapping['name'] ?? null)) {
            return Route::has($mapping['name']) ? route($mapping['name']) : null;
        }

        $id = $mapping['id'] ?? null;
        if (! is_int($id)) {
            return null;
        }

        return match ($type) {
            'project' => $this->urlForProject($id),
            'post' => $this->urlForPost($id),
            'portfolio' => $this->urlForPortfolio($id),
            default => null,
        };
    }

    private function urlForProject(int $id): ?string
    {
        $project = Project::find($id);
        return $project?->slug ? route('productos.show', ['slug' => $project->slug]) : null;
    }

    private function urlForPost(int $id): ?string
    {
        $post = Post::find($id);
        return $post ? url('/post/'.Str::slug($post->title).'-'.$post->id) : null;
    }

    private function urlForPortfolio(int $id): ?string
    {
        $item = PortfolioItem::find($id);
        return $item?->slug ? route('portfolio.show', ['slug' => $item->slug]) : null;
    }

    private function logMiss(string $path, string $reason, ?int $oldId = null): void
    {
        Log::info('legacy_redirect.miss', [
            'path' => $path,
            'reason' => $reason,
            'old_id' => $oldId,
        ]);
    }
}

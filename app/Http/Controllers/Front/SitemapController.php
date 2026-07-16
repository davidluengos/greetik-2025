<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Project;
use App\Models\SitePage;
use Carbon\CarbonInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            $this->entry(route('home'), now(), 'daily', '1.0'),
            $this->entry(route('servicios.index'), null, 'weekly', '0.8'),
            $this->entry(route('posts.index'), null, 'weekly', '0.7'),
        ];

        foreach (SitePage::query()->where('is_active', true)->cursor() as $page) {
            $loc = $page->publicUrl();
            if ($loc === null) {
                continue;
            }

            $priority = in_array($page->slug, SitePage::legalSlugs(), true) ? '0.3' : '0.7';
            $urls[] = $this->entry($loc, $page->updated_at, 'monthly', $priority);
        }

        foreach (Project::query()->where('is_active', true)->orderBy('menu_order')->cursor() as $project) {
            $urls[] = $this->entry(
                route('productos.show', $project->slug),
                $project->updated_at,
                'weekly',
                '0.8'
            );
        }

        foreach (PortfolioItem::query()->published()->orderBy('menu_order')->cursor() as $item) {
            $urls[] = $this->entry(
                route('portfolio.show', $item->slug),
                $item->updated_at,
                'monthly',
                '0.6'
            );
        }

        foreach (Post::query()->published()->orderByDesc('publishdate')->cursor() as $post) {
            $urls[] = $this->entry(
                url('/post/'.Str::slug($post->title).'-'.$post->id),
                $post->lastedit ?? $post->publishdate,
                'monthly',
                '0.5'
            );
        }

        $urls = collect($urls)
            ->unique(static fn (array $entry): string => $entry['loc'])
            ->values()
            ->all();

        return response()
            ->view('front.sitemap', compact('urls'), 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * @return array{loc: string, lastmod: ?string, changefreq: string, priority: string}
     */
    private function entry(
        string $loc,
        CarbonInterface|Carbon|string|null $lastmod,
        string $changefreq,
        string $priority
    ): array {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod !== null ? Carbon::parse($lastmod)->toAtomString() : null,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }
}

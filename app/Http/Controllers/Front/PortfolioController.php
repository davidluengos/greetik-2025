<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\SitePage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        abort_unless(Schema::hasTable('site_pages'), 404);

        $page = SitePage::query()
            ->where('slug', 'portfolio')
            ->where('is_active', true)
            ->firstOrFail();

        $items = collect();
        if (Schema::hasTable('portfolio_items')) {
            $items = PortfolioItem::query()
                ->published()
                ->orderBy('menu_order')
                ->orderBy('title')
                ->get();
        }

        $categorySlugs = $items
            ->map(fn (PortfolioItem $item) => Str::slug($item->category ?: 'general'))
            ->unique()
            ->values();

        $categoryLabels = [];
        foreach ($items as $item) {
            $slug = Str::slug($item->category ?: 'general');
            if (! array_key_exists($slug, $categoryLabels)) {
                $categoryLabels[$slug] = $item->category ?: 'General';
            }
        }

        return view('front.portfolio', compact('page', 'items', 'categorySlugs', 'categoryLabels'));
    }

    public function show(string $slug): View
    {
        abort_unless(Schema::hasTable('portfolio_items'), 404);

        $item = PortfolioItem::query()
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $page = null;
        if (Schema::hasTable('site_pages')) {
            $page = SitePage::query()->where('slug', 'portfolio')->where('is_active', true)->first();
        }

        return view('front.portfolio-item', compact('item', 'page'));
    }
}

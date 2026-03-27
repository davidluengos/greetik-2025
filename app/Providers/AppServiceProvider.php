<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\SitePage;
use App\Models\Post;
use App\Models\ProductForm;
use App\Models\PortfolioItem;
use App\Models\PricingTable;
use App\Models\Service;
use App\Policies\ManageContentPolicy;
use App\View\Composers\FrontHeaderComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::policy(Service::class, ManageContentPolicy::class);
        Gate::policy(Project::class, ManageContentPolicy::class);
        Gate::policy(Post::class, ManageContentPolicy::class);
        Gate::policy(PortfolioItem::class, ManageContentPolicy::class);
        Gate::policy(ProductForm::class, ManageContentPolicy::class);
        Gate::policy(PricingTable::class, ManageContentPolicy::class);
        Gate::policy(SitePage::class, ManageContentPolicy::class);
        View::composer(['front.layouts.header', 'front.layouts.footer'], FrontHeaderComposer::class);
    }
}

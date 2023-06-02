<?php

namespace App\Providers;

use App\Repositories\ElasticSearchRepository;
use App\Repositories\EloquentSearchRepository;
use App\Repositories\SearchRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SearchRepository::class, function ($app) {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (!config('services.elasticsearch.enabled')) {
                return new EloquentSearchRepository();
            }

            return new ElasticSearchRepository(
                $app->make(Client::class)
            );
        });
        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // enable paginate collection
        Collection::macro('paginate', function($perPage, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage)->values(),
                $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.elasticsearch.hosts'))
                ->build();
        });
    }
}

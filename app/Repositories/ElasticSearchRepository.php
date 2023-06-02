<?php

namespace App\Repositories;

use App\Models\Product;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ElasticSearchRepository implements SearchRepository
{
    /** @var Client */
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $search = ''): Collection
    {
        $items = $this->searchOnElasticSearch($search);

        return $this->build($items);
    }

    private function searchOnElasticSearch(string $search = ''): array
    {
        $model = new Product();

        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                "query" => [
                    "query_string" => [
                        "query" => "*$search*",
                        "fields" => [
                            "title",
                            "details",
                        ]
                    ]
                ],
            ],
        ]);
    }

    private function build(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Product::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class EloquentSearchRepository implements SearchRepository
{
    public function search(string $search): Collection
    {
        return Product::query()
            ->where(fn ($query) => (
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('details', 'LIKE', "%{$search}%")
            ))->get();
    }
}
<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * @method static findMany(array $ids)
 */
class Product extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $fillable = ['title','details'];

    function bookmark(): HasOne {
        return $this->hasOne(ProductBookmark::class, 'product_id')->where('user_id', Auth::user()->id);
    }
}

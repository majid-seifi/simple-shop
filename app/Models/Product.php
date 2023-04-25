<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title','details'];

    function bookmark(): HasOne {
        return $this->hasOne(ProductBookmark::class, 'product_id')->where('user_id', Auth::user()->id);
    }
}

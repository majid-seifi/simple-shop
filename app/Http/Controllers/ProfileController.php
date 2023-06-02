<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * get current authenticated user profile
     *
     * @return JsonResponse
     */
    public function show()
    {
        $products = Product::select(['id','title'])->whereHas('bookmark')->paginate(5);
        $products->withPath('/profile');
        return response()->json([
            'user' => auth()->user(),
            'products' => $products,
        ]);
    }
}

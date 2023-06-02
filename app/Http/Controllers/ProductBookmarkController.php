<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductBookmark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductBookmarkController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function bookmark(Request $request, Product $product)
    {
        try {
            $validateProduct = Validator::make($request->all(),
                [
                    'type' => 'required|in:save,remove',
                ]);

            if ($validateProduct->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProduct->errors()
                ], 403);
            }
            $type = $request->get('type');
            if ($type === 'save') {
                ProductBookmark::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
                $msg = 'Bookmarked';
            } else {
                ProductBookmark::where([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ])->delete();
                $msg = 'UnBookmarked';
            }
            return response()->json([
                'message' => "Product $msg Successfully!!!",
                'product' => new ProductResource($product),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductBookmark;
use App\Repositories\SearchRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(SearchRepository $searchRepository)
    {
        $products = request()->has('search')
            ? $searchRepository->search(request('search'))
            : Product::select(['id','title']);
        $products = $products->paginate(10);
        $products->withPath('/products');
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validateProduct = Validator::make($request->all(),
                [
                    'title' => 'required',
                    'details' => 'required'
                ]);

            if ($validateProduct->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProduct->errors()
                ], 403);
            }
            $product = Product::create($request->post());
            return response()->json([
                'message' => 'Product Created Successfully!!!',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validateProduct = Validator::make($request->all(),
                [
                    'title' => 'required',
                    'details' => 'required'
                ]);

            if ($validateProduct->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProduct->errors()
                ], 403);
            }
            $product->fill($request->post())->save();
            return response()->json([
                'message' => 'Product Updated Successfully!!!',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product Deleted Successfully!!!'
        ]);
    }
}

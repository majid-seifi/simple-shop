<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API router for your application. These
| router are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show']);

        Route::middleware('permission:Create product')->post('product', [\App\Http\Controllers\ProductController::class, 'store']);
        Route::middleware('permission:Read product')->get('product/{product}', [\App\Http\Controllers\ProductController::class, 'show']);
        Route::middleware('permission:Update product')->patch('product/{product}', [\App\Http\Controllers\ProductController::class, 'update']);
        Route::middleware('permission:Delete product')->delete('product/{product}', [\App\Http\Controllers\ProductController::class, 'destroy']);
        Route::middleware('permission:Bookmark product')->post('product/bookmark/{product}', [\App\Http\Controllers\ProductBookmarkController::class, 'bookmark']);
    });
    Route::get('product', [\App\Http\Controllers\ProductController::class, 'index']);
});

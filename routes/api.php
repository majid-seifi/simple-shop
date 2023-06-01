<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductBookmarkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [ProfileController::class, 'show']);

        Route::middleware('permission:Create product')->post('product', [ProductController::class, 'store']);
        Route::middleware('permission:Read product')->get('product/{product}', [ProductController::class, 'show']);
        Route::middleware('permission:Update product')->patch('product/{product}', [ProductController::class, 'update']);
        Route::middleware('permission:Delete product')->delete('product/{product}', [ProductController::class, 'destroy']);
        Route::middleware('permission:Bookmark product')->post('product/bookmark/{product}', [ProductBookmarkController::class, 'bookmark']);
    });
    Route::get('product', [ProductController::class, 'index']);
});

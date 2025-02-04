<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('products', ProductController::class);
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('order-history/{user_id}', [OrderController::class, 'getOrderHistory']);

    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::post('cart/remove', [CartController::class, 'removeFromCart']);
    Route::get('cart', [CartController::class, 'getCart']);
    Route::delete('cart/clear', [CartController::class, 'clearCart']);
});

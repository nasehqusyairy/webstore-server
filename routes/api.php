<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'loginAsAdmin']);
Route::get('/dashboard', [DashboardController::class, 'all']);

// Contoh route yang memerlukan autentikasi
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [UserController::class, 'attributes']);
    Route::put('/user/{user}', [UserController::class, 'update']);
    Route::get('/user/orders', [UserController::class, 'orders']);
    Route::get('/user/cards', [UserController::class, 'cards']);
    Route::get('/user/addresses', [UserController::class, 'addresses']);

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('sponsors', SponsorController::class);
    Route::apiResource('cards', CardController::class);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('shippings', ShippingController::class);
    Route::apiResource('orders', TransactionController::class);
});
// Route::apiResource('orders', TransactionController::class);

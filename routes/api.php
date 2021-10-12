<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('users', UserController::class)->only(['store', 'show']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::post('/carts', [CartController::class, 'store']);
Route::get('/carts/{cart:key}', [CartController::class, 'show']);
Route::post('/carts/{cart:key}', [CartController::class, 'addItem']);
Route::post('/carts/{cart:key}/checkout', [CartController::class, 'checkout']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;

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

// add middleware santum for protect route
Route::middleware('auth:sanctum')->group(function () {
    // route for logout
    Route::post('logout', [LoginController::class, 'logout']);
    // route for fetch-profile
    Route::get('user/profile', [LoginController::class, 'profile']);
    // route for products
    Route::resource('products', ProductController::class)->except(['edit', 'create']);
});

// route for login
Route::post('login', [LoginController::class, 'login']);
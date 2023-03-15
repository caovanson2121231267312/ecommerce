<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function () {
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::resource('tags', TagController::class)->except(['create', 'edit']);
    Route::resource('vouchers', VoucherController::class)->except(['create', 'edit']);
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
});

// Route::group(['middleware' => 'api', 'prefix' => 'auth', 'namespace' => 'Api'], function ($router) {
Route::group(['prefix' => '/admin', 'prefix' => 'auth'], function () {
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Admin\AuthController::class, 'register']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);
    Route::post('/refresh', [App\Http\Controllers\Admin\AuthController::class, 'refresh']);
    Route::get('/user-profile', [App\Http\Controllers\Admin\AuthController::class, 'userProfile']);
    Route::post('/change-pass', [App\Http\Controllers\Admin\AuthController::class, 'changePassWord']);
});

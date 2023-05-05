<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RateController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function () {
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::resource('tags', TagController::class)->except(['create', 'edit']);
    Route::resource('brands', BrandController::class)->except(['create', 'edit']);
    Route::resource('vouchers', VoucherController::class)->except(['create', 'edit']);
    Route::resource('products', ProductController::class);
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit']);
    Route::resource('payments', PaymentController::class)->except(['create', 'edit']);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
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

Route::controller(homeController::class)->group(function () {
    Route::get('/products', 'index')->name('products');
    Route::get('/hotSale', 'hotSale')->name('hotSale');
    Route::get('/categories', 'categories')->name('categories');
    Route::get('/product/{slug}', 'product')->name('product');
    Route::get('/rateOfProduct/{id}', 'rateOfProduct')->name('rateOfProduct');
    Route::post('/carts', 'cart')->name('cart');
    // Route::post('/orders', 'store');
});

Route::post('/rate', [RateController::class, 'store'])->name('rate');

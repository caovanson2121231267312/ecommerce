<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
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
    Route::resource('orders', OrderController::class);
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
    Route::get('/export', 'export')->name('export');
    Route::get('/email', 'email')->name('email');
    // Route::post('/orders', 'store');
});

Route::post('/rate', [RateController::class, 'store'])->name('rate');

Route::controller(Api\PaymentController::class)->group(function () {
    Route::get('/vnpay', 'vnpay')->name('vnpay');
    Route::post('/create_payment', 'create_payment')->name('create_payment');
});

Route::controller(Api\EnumController::class)->group(function () {
    Route::get('/status_order', 'status_order')->name('status_order');
});

Route::controller(Api\OrderController::class)->group(function () {
    Route::post('/order/{ref}', 'update')->name('order_update_status');
    Route::get('/orders/{ref}', 'index')->name('get_orders');
});

Route::controller(Api\ChatController::class)->group(function () {
    Route::get('/chat', 'index')->name('chats');
    Route::get('/messages/{id}/{member_id}', 'messages')->name('messages');
    Route::post('/messages/create/{id}', 'store')->name('messages_create');
    Route::get('/get_technical_support', 'get_technical_support')->name('get_technical_support');
    Route::get('/get_users_chat', 'get_users_chat')->name('get_users_chat');
});

// Broadcast::routes(['middleware' => ['jwt.auth']]);
// Broadcast::routes(['middleware' => ['auth:api']]);
// Broadcast::routes(['middleware' => 'web']);
// Broadcast::routes();

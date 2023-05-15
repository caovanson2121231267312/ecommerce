<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(Api\PaymentController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    // Route::get('/vnpay', 'vnpay')->name('vnpay');
    // Route::post('/create_payment', 'create_payment')->name('create_payment');
});

Route::controller(Api\PayPalController::class)->group(function () {
    Route::get('create-transaction', 'createTransaction')->name('createTransaction');
    Route::get('process-transaction',  'processTransaction')->name('processTransaction');
    Route::get('success-transaction',  'successTransaction')->name('successTransaction');
    Route::get('cancel-transaction',  'cancelTransaction')->name('cancelTransaction');
});

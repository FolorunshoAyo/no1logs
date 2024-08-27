<?php

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

Route::controller('ApiController')->prefix('v1')->name('api.')->middleware(['api.token', 'sanitize'])->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/products', 'products')->name('products');
    Route::get('/category-products/{id?}', 'categoryProducts')->name('category.products');
    Route::get('/product/details/{id?}', 'productDetails')->name('product.details');
    Route::get('/product/{id}', 'getSingleProduct')->name('getProduct');
    Route::get('/account/{id}', 'getSingleAccount')->name('getAccount');
    Route::get('/order/new', 'newOrder')->name('new.order');
    Route::get('/order/details/{id}', 'orderDetails')->name('get.order');
    Route::get('/check-balance', 'balance')->name('balance');
    // Route::get('/check-accounts', 'checkAccounts')->name('checkAccounts');

    // Fallback route for undefined routes
    Route::fallback(function () {
        return response()->json(['error' => 'Route Not Found.'], 404);
    });
});
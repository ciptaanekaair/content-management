<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutentikasiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;

/**
 * Route API untuk modul register dan login
 */
//route registrasi account
Route::post('/register', [AutentikasiController::class, 'registrasi'])->name('api_registrasi');
// route login
Route::post('/login', [AutentikasiController::class, 'login'])->name('api_login');
// route logout

/**
 * Route API untuk product & kategori produk
 */
Route::get('/products', [ProductController::class, 'index'])->name('api_products_data');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('api_product_detail');
Route::get('/products/search/{keywords}', [ProductController::class, 'search'])->name('api_product_search');

// Product Categories
Route::get('product-category', [ProductCategoryController::class, 'index'])->name('api_product_cat_data');
Route::get('product-category/{slug}', [ProductCategoryController::class, 'show'])->name('api_product_cat_detail');
Route::get('product-category/search/{keywords}', [ProductCategoryController::class, 'search'])->name('api_product_cat_search');

/**
 * Route Group yang harus melalui autentikasi
 */
Route::group(['middleware' => ['auth:sanctum']], function(){

    // User profile for editing.
    Route::get('user/{username}', [ProfileController::class, 'getProfile'])->name('api_user_profile.data');
    // Update profile
    Route::put('user/{username}', [ProfileController::class, 'updateProfile'])->name('api_user_profile.update');

    // Route for Cart
    // https://documenter.getpostman.com/view/5639352/Tzm8EF9u
    Route::get('cart', [CartController::class, 'index'])->name('api_cart_data');
    Route::post('add-to-cart', [CartController::class, 'store'])->name('api_add_to_cart');
    Route::put('update-cart', [CartController::class, 'updateCart'])->name('api_update_cart');
    Route::delete('cart/delete/{id}', [CartController::class, 'deleteCart'])->name('api_delete_from_cart');

    // Route for validate voucher
    Route::post('/check_voucher', [CheckoutController::class, 'validasiVoucher'])->name('api_validasi_voucher');

    // Route for checkout
    Route::post('checkout', [CheckoutController::class, 'checkout'])->name('api_checkout');
    
    // Logout route
    Route::get('/logout', [AutentikasiController::class, 'logout'])->name('api_logout');

});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutentikasiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\SocialLoginController;
use App\Http\Controllers\Api\WilayahIndonesiaController;
use App\Http\Controllers\Api\PaymentMethodController;

/**
 * Route API untuk modul register dan login
 */
//route registrasi account
Route::post('/register', [AutentikasiController::class, 'registrasi'])->name('api_registrasi');
// route login
Route::post('/login', [AutentikasiController::class, 'login'])->name('api_login');
// route socialite
Route::get('/login/{service}', [SocialLoginController::class, 'redirect']);
Route::get('/login/{service}/callback', [SocialLoginController::class, 'callback']);

/**
 * Route API untuk product & kategori produk
 */
Route::get('/products', [ProductController::class, 'index'])->name('api_products_data');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('api_product_detail');
Route::post('/products/search', [ProductController::class, 'search'])->name('api_product_search');

// Product Categories
Route::get('product-category', [ProductCategoryController::class, 'index'])->name('api_product_cat_data');
Route::get('product-category/{slug}', [ProductCategoryController::class, 'show'])->name('api_product_cat_detail');
Route::get('product-category/search/{keywords}', [ProductCategoryController::class, 'search'])->name('api_product_cat_search');

// Wilayah
Route::get('provinsi', [WilayahIndonesiaController::class, 'provinsiIndex'])->name('api_data_provinsi'); // all provinsi
Route::get('provinsi/{id}', [WilayahIndonesiaController::class, 'provinsiShow'])->name('api_detail_provinsi'); // all kota in provinsi by id provinsi
Route::get('kota', [WilayahIndonesiaController::class, 'kotaIndex'])->name('api_data_kota'); // all kota
Route::get('kota/{id}', [WilayahIndonesiaController::class, 'kotaShow'])->name('api_detail_kota'); // all kota in kecamatan by id kota
Route::get('kecamatan', [WilayahIndonesiaController::class, 'kecamatanIndex'])->name('api_data_kecamatan'); // all kecamatan
Route::get('kecamatan/{id}', [WilayahIndonesiaController::class, 'kecamatanShow'])->name('api_detail_kecamatan'); // all kelurahan in kota by id kecamatan
Route::get('kelurahan', [WilayahIndonesiaController::class, 'kelurahanIndex'])->name('api_data_kelurahan'); // all kelurahan
Route::get('kelurahan/{id}', [WilayahIndonesiaController::class, 'kelurahanShow'])->name('api_detail_kelurahan'); // detail kelurahan


/**
 * Route Group yang harus melalui autentikasi
 */
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('profile', [ProfileController::class, 'getProfile'])->name('api_user_profile.data');// User profile for editing.
    // update profile di maintenance sementara
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('api_user_profile.update');// Update profile

    // Route for Cart
    Route::get('cart', [CartController::class, 'index'])->name('api_cart_data'); // mengambil seluruh data cart.
    Route::post('add-to-cart', [CartController::class, 'store'])->name('api_add_to_cart'); // memasukan produk pada keranjang.
    // Route::put('update-cart', [CartController::class, 'updateCart'])->name('api_update_cart');
    Route::post('plus_one', [CartController::class, 'handlePlus'])->name('api_cart_plus_one'); // menambah quantity 1.
    Route::post('minus_one', [CartController::class, 'handleMinus'])->name('api_cart_minus_one'); // mengurangi quantity 1.
    Route::delete('cart/delete/{id}', [CartController::class, 'deleteCart'])->name('api_delete_from_cart'); // delete produk pada cart.

    // Route for validate voucher
    Route::post('check_voucher', [CheckoutController::class, 'validasiVoucher'])->name('api_validasi_voucher');
    // Route for checkout
    Route::post('checkout', [CheckoutController::class, 'checkout'])->name('api_checkout');
    Route::post('checkout/confirm', [CheckoutController::class, 'confirmCheckout'])->name('api_confirm_checkout');

    Route::get('payment-method', [PaymentMethodController::class, 'index'])->name('api_payment_method'); // get payment method

    Route::get('metode-pembayaran', [CheckoutController::class, 'getMetodeBayar'])->name('api_get_metodebayar');// load metode pembayaran
    
    // Logout route
    Route::get('logout', [AutentikasiController::class, 'logout'])->name('api_logout');

});
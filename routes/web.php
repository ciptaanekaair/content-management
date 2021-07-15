<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::view('/', 'welcome')->name('welcome');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Product Category Route
    Route::resource('/product-categories', ProductCategoryController::class);
    Route::get('/product-category/data', [ProductCategoryController::class, 'getData'])->name('product-catetgories.data');

    // Product Route
    Route::resource('/products', ProductController::class);
    Route::get('/products/data', [ProductController::class, 'getData'])->name('product.data');

    // Profile Route
    Route::get('/profile/{username}', [ProfileController::class, 'getProfile'])->name('profile.show');
    Route::patch('/profile/{username}', [ProfileController::class, 'update'])->name('profile.update');

    // Product Route
    Route::resource('/users', ProductController::class);
    Route::get('/users/data', [ProductController::class, 'getData'])->name('users.data');
});

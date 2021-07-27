<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PenggunaDetailController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\RekamJejakController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AttachingLevelController;
use App\Http\Controllers\Admin\KotaController;


/*
|--------------------------------------------------------------------------
| FilterPedia.co.id Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::view('/', 'welcome')->name('welcome');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Product Category Route
    Route::resource('product-categories', ProductCategoryController::class);
    Route::get('data/product-categories', [ProductCategoryController::class, 'getData'])->name('product-catetgories.data');
    Route::get('data/products-categories/export', [ProductCategoryController::class, 'exportData'])->name('product-categories.data.export');

    // Product Route
    Route::resource('products', ProductController::class);
    Route::get('data/products', [ProductController::class, 'getData'])->name('product.data');
    Route::get('data/products/export', [ProductController::class, 'exportData'])->name('product.data.export');

    // product images
    Route::post('products/images', [ProductImageController::class, 'store'])->name('product-images.store');
    Route::get('products/images/{id}', [ProductImageController::class, 'edit'])->name('product-images.edit');
    Route::put('products/images/{id}', [ProductImageController::class, 'update'])->name('product-images.update');
    Route::delete('products/images/{id}/hapus', [ProductImageController::class, 'delete'])->name('product-images.delete');
    Route::get('products/{id}/images', [ProductImageController::class, 'getData'])->name('product-images.data');

    // Profile Route
    Route::get('profile/{username}', [ProfileController::class, 'getProfile'])->name('profile.show');
    Route::patch('profile/{username}', [ProfileController::class, 'update'])->name('profile.update');

    // Product Route
    Route::resource('pengguna', PenggunaController::class);
    Route::get('data/pengguna', [PenggunaController::class, 'getData'])->name('pengguna.data');
    Route::get('data/pengguna/export', [PenggunaController::class, 'exportData'])->name('pengguna.data.export');

    Route::get('pengguna-detail/{id}/edit', [PenggunaDetailController::class, 'edit']);
    Route::put('pengguna-detail/{id}', [PenggunaDetailController::class, 'update']);

    Route::resource('transactions', TransaksiController::class);
    Route::get('data/transactions', [TransaksiController::class, 'getData'])->name('transactions.data');

    Route::get('user-histories', [RekamJejakController::class, 'index'])->name('user-histories.index');
    Route::get('data/user-histories', [RekamJejakController::class, 'getData'])->name('user-histories.data');
    Route::get('user-histories/{id}', [RekamJejakController::class, 'getUser'])->name('user-histories.user');

    Route::resource('levels', LevelController::class);
    Route::get('data/levels', [LevelController::class, 'getData'])->name('levels.data');
    Route::resource('roles', RoleController::class);
    Route::get('data/roles', [RoleController::class, 'getData'])->name('roles.data');
    // Modul Provinsi
    Route::resource('provinsis', ProvinsiController::class);
    Route::get('data/provinsis', [ProvinsiController::class, 'getData'])->name('provinsis.data');
    Route::get('data/provinsis/import', [ProvinsiController::class, 'importData'])->name('provinsis.import');
    // Modul Kota
    Route::resource('kotas', KotaController::class);
    Route::get('data/kotas', [KotaController::class, 'getData'])->name('kotas.data');
    Route::post('data/kotas/import', [KotaController::class, 'importData'])->name('kotas.import');
    // Modul Kota
    Route::resource('kecamatans', App\Http\Controllers\Admin\KecamatanController::class);
    Route::get('data/kecamatans', [App\Http\Controllers\Admin\KecamatanController::class, 'getData'])->name('kecamatans.data');
    Route::post('data/kecamatans/import', [App\Http\Controllers\Admin\KecamatanController::class, 'importData'])->name('kecamatans.import');

    // attaching level
    Route::post('roles/attach', [AttachingLevelController::class, 'attachLevel'])->name('roles.attach');
});

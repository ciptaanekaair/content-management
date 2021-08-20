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

Route::get('/', [DashboardController::class, 'gotoLogin'])->name('welcome');
Route::get('/google-stats', [DashboardController::class, 'grafikChartDua'])->name('google-stats');

Route::view('/contoh-invoice', 'contoh-invoice')->name('contoh-invoice');

// Forget Password
Route::get('/forget-password', [App\Http\Controllers\Admin\ForgetPasswordController::class, 'index'])->name('forgetpassword.index');
Route::post('/forget-password', [App\Http\Controllers\Admin\ForgetPasswordController::class, 'sendToken'])->name('forgetpassword.sendToken');
Route::get('/reset-password', [App\Http\Controllers\Admin\ForgetPasswordController::class, 'indexResetPass'])->name('forgetpassword.indexResetPass');
Route::post('/reset-password', [App\Http\Controllers\Admin\ForgetPasswordController::class, 'resetPassword'])->name('forgetpassword.resetPassword');

// Tester Upload menggunakan watermark. Hapus saat berhasil.
Route::get('/upload-tester', [App\Http\Controllers\UploadGambarTesterController::class, 'index'])->name('uploaded.index');
Route::post('/upload-tester', [App\Http\Controllers\UploadGambarTesterController::class, 'store'])->name('uploaded.store');

Route::get('/logout', function() {
    Session()->flush();

    return Redirect::to('/login');
})->name('get-logout');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('charts', [DashboardController::class, 'grafikChartSatu'])->name('grafiksatu');
    Route::get('check/transaction/verify', [DashboardController::class, 'checkNeedFerify'])->name('checkNeedFerify');

    // Profile
    Route::get('my-profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::post('my-profile/update-password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('my-profile/update-profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update.profile');
    Route::post('my-profile/update-detail', [App\Http\Controllers\Admin\ProfileController::class, 'updateDetail'])->name('profile.update.detail');

    // Product Category Route
    Route::resource('product-categories', ProductCategoryController::class);
    Route::get('data/product-categories', [ProductCategoryController::class, 'getData'])->name('product-catetgories.data');
    Route::get('data/products-categories/export', [ProductCategoryController::class, 'exportData'])->name('product-categories.data.export');

    // Product Route
    Route::resource('products', ProductController::class);
    Route::get('data/products', [ProductController::class, 'getData'])->name('product.data');
    Route::get('products/detail/{id}', [ProductController::class, 'getDetail'])->name('product.detail');
    Route::get('data/products/export', [ProductController::class, 'exportData'])->name('product.data.export');

    // product images
    Route::post('products/images', [ProductImageController::class, 'store'])->name('product-images.store');
    Route::get('products/images/{id}', [ProductImageController::class, 'edit'])->name('product-images.edit');
    Route::put('products/images/{id}', [ProductImageController::class, 'update'])->name('product-images.update');
    Route::delete('products/images/{id}/hapus', [ProductImageController::class, 'delete'])->name('product-images.delete');
    Route::get('products/{id}/images', [ProductImageController::class, 'getData'])->name('product-images.data');

    // Product Route
    Route::resource('pengguna', PenggunaController::class);
    Route::get('data/pengguna', [PenggunaController::class, 'getData'])->name('pengguna.data');
    Route::get('data/pengguna/export', [PenggunaController::class, 'exportData'])->name('pengguna.data.export');

    Route::get('pengguna-detail/{id}/edit', [PenggunaDetailController::class, 'edit']);
    Route::put('pengguna-detail/{id}', [PenggunaDetailController::class, 'update']);

    Route::get('pengguna-staff', [App\Http\Controllers\Admin\UserStaffController::class, 'index'])->name('pengguna-staff.index');
    Route::get('data/pengguna-staff', [App\Http\Controllers\Admin\UserStaffController::class, 'getData'])->name('pengguna-staff.data');

    // Modul Transaksi
    Route::resource('transactions', TransaksiController::class);
    Route::get('data/transactions', [TransaksiController::class, 'getData'])->name('transactions.data');
    Route::get('data/transactions/status/{id}', [TransaksiController::class, 'showAjax'])->name('transactions.ajax-data');

    // Modul Laporan: harian, mingguan, bulanan
    Route::get('transaction-report/daily', [App\Http\Controllers\Admin\LaporanTransaksiController::class, 'harian'])->name('report.index.harian');
    Route::post('data/transaction-report/daily', [App\Http\Controllers\Admin\LaporanTransaksiController::class, 'exportHarian'])->name('report.harian');
    Route::get('transaction-report/date-to-date', [App\Http\Controllers\Admin\LaporanTransaksiController::class, 'dateToDate'])->name('report.index.datetodate');
    Route::post('data/transaction-report/date-to-date', [App\Http\Controllers\Admin\LaporanTransaksiController::class, 'exportDateToDate'])->name('report.datetodate');

    Route::get('data-payment/transaction/{id}', [App\Http\Controllers\Admin\PaymentConfirmationController::class, 'getDetail'])->name('payment.detail');
    Route::get('transaction/verify/{id}', [App\Http\Controllers\Admin\PaymentConfirmationController::class, 'verify'])->name('payment.verify');
    Route::get('transaction/unverify/{id}', [App\Http\Controllers\Admin\PaymentConfirmationController::class, 'unverify'])->name('payment.unverify');
    Route::get('transaction/terminate/{id}', [App\Http\Controllers\Admin\PaymentConfirmationController::class, 'terminated'])->name('payment.terminated');

    // Shipping
    Route::resource('shippings', App\Http\Controllers\Admin\ShippingController::class);
    Route::get('data/shippings/transaction/{id}', [App\Http\Controllers\Admin\ShippingController::class, 'getTransactions'])->name('shippings.getTransactions');
    Route::get('data/shippings', [App\Http\Controllers\Admin\ShippingController::class, 'getData'])->name('shippings.data');

    // User Histories
    Route::get('user-histories', [RekamJejakController::class, 'index'])->name('user-histories.index');
    Route::get('data/user-histories', [RekamJejakController::class, 'getData'])->name('user-histories.data');
    Route::get('user-histories/{id}', [RekamJejakController::class, 'show'])->name('user-histories.user');

    Route::resource('levels', LevelController::class);
    Route::get('data/levels', [LevelController::class, 'getData'])->name('levels.data');
    Route::resource('roles', RoleController::class);
    Route::get('data/roles', [RoleController::class, 'getData'])->name('roles.data');

    // Modul Provinsi
    Route::resource('provinsis', App\Http\Controllers\Admin\ProvinsiController::class)->except(['create', 'show']);
    Route::get('data/provinsis', [App\Http\Controllers\Admin\ProvinsiController::class, 'getData'])->name('provinsis.data');
    Route::get('data/provinsis/import', [App\Http\Controllers\Admin\ProvinsiController::class, 'importData'])->name('provinsis.import');

    // Modul Kota
    Route::resource('kotas', KotaController::class)->except(['create']);
    Route::get('data/kotas', [KotaController::class, 'getData'])->name('kotas.data');
    Route::post('data/kotas/import', [KotaController::class, 'importData'])->name('kotas.import');

    // Modul Kecamatan
    Route::resource('kecamatans', App\Http\Controllers\Admin\KecamatanController::class)->except(['create']);
    Route::get('data/kecamatans', [App\Http\Controllers\Admin\KecamatanController::class, 'getData'])->name('kecamatans.data');
    Route::post('data/kecamatans/import', [App\Http\Controllers\Admin\KecamatanController::class, 'importData'])->name('kecamatans.import');

    // Product Banner Position
    Route::resource('banner-positions', App\Http\Controllers\Admin\BannerPositionController::class);
    Route::get('data/banner-positions', [App\Http\Controllers\Admin\BannerPositionController::class, 'getData'])->name('banner-positions.data');

    // Payment Method
    Route::resource('payment-methodes', App\Http\Controllers\Admin\PaymentCodeController::class);
    Route::get('data/payment-methodes', [App\Http\Controllers\Admin\PaymentCodeController::class, 'getData'])->name('payment-methodes.data');

    // Product Banner
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    Route::get('data/banners', [App\Http\Controllers\Admin\BannerController::class, 'getData'])->name('banners.data');

    // Roles
    Route::post('roles/attach', [App\Http\Controllers\Admin\AttachingLevelController::class, 'attachLevel'])->name('roles.attach'); // attaching level
    Route::post('roles/unattach', [App\Http\Controllers\Admin\AttachingLevelController::class, 'unattachLevel'])->name('roles.unattach'); // unattaching level

    // Website Settings
    Route::get('general-settings', [App\Http\Controllers\Admin\GeneralSettingController::class, 'index'])->name('general-settings.index');
    Route::post('general-settings/setting', [App\Http\Controllers\Admin\GeneralSettingController::class, 'simpanSetting'])->name('general-settings.simpanSetting');
    Route::post('general-settings/seo', [App\Http\Controllers\Admin\GeneralSettingController::class, 'simpanSeo'])->name('general-settings.simpanSeo');
    Route::post('general-settings/midtrans', [App\Http\Controllers\Admin\GeneralSettingController::class, 'simpanMidtrans'])->name('general-settings.simpanMidtrans');
});

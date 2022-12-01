<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EditorOnlineController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\TrackingOrderController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\OrderTanpaLoginController;
use App\Http\Controllers\PrintERP\QueueOnlineController;

// AUTH 
Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('loginPage');
    Route::post('login', [LoginController::class, 'loginPhone'])->name('login');
    //forgot-password
    Route::get('lupa-password', [ResetPasswordController::class, 'index'])->name('verifikasi.akun');
    Route::get('reset-password', [ResetPasswordController::class, 'resetPage'])->name('forgotPage');
    Route::post('verifikasi-akun', [ResetPasswordController::class, 'checkAccount'])->name('check.account');
    Route::post('verifikasi-pin', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');

    // google
    Route::get('with-google', [LoginController::class, 'loginGoogle'])->name('google.login');
    Route::get('get-data-google', [LoginController::class, 'validateGoogleCallback'])->name('callback.google');
    //tanpa register
    Route::get('tanpa-register', [OrderTanpaLoginController::class, 'tanpaRegisterPage'])->name('tanpa.register');
    Route::post('tanpa-register', [OrderTanpaLoginController::class, 'tanpaRegister'])->name('order.tanpa.login');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// BERANDA / HOME
Route::get('/test',function(){
    $data = DB::table('idp_orders')->get();
    return response()->json($data);
});
Route::post('/orders-api', [CheckoutController::class, 'store'])->name('store');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('cara-order', [HomeController::class, 'caraOrder'])->name('cara.order');
Route::get('price-list', [HomeController::class, 'priceList'])->name('price.list');
Route::get('price-list/{images}', [HomeController::class, 'downloadPriceList'])->name('download.price.list');
Route::get('toko-kami', [HomeController::class, 'tokoKami'])->name('toko.kami');
Route::get('syarat-dan-ketentuan', [HomeController::class, 'term'])->name('term');
Route::get('privacy-and-security', [HomeController::class, 'privacy'])->name('privacy');
Route::get('frequently-asked-questions', [HomeController::class, 'faq'])->name('faq');
Route::get('daftar-rekening-bank', [HomeController::class, 'daftarBank'])->name('daftar.bank');

// PRODUCTS / PRODUK-
Route::get('produk', [ProductController::class, 'index'])->name('products');
Route::get('semua-produk', [ProductController::class, 'allProducts'])->name('all.products');
Route::get('kategori-produk/{id}', [ProductController::class, 'productCategory'])->name('category');
Route::get('pencarian', [ProductController::class, 'productSearch'])->name('pencarian');

// PRODUCT DETAIL-
Route::get('produk/{id}', [ProductDetailController::class, 'detail'])->name('product');
Route::post('add-to-cart', [ProductDetailController::class, 'store'])->name('store.product');

//DESIGN ONLINE
Route::get('template/{id}', [ProductController::class, 'designCategory'])->name('template');
Route::get('preview/{id}', [ProductDetailController::class, 'designTemplate'])->name('preview');

Route::get('design-online', [EditorOnlineController::class, 'index'])->name('design.online');
Route::get('get-design-online', [EditorOnlineController::class, 'getDesign'])->name('get.design');
Route::post('set-design-online', [EditorOnlineController::class, 'setDesign'])->name('set.design');

// CART / KERANJANG
Route::prefix('keranjang')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::get('/hapus/{id}', [CartController::class, 'destroy'])->name('delete.cart');
    Route::post('/update-note', [CartController::class, 'updateNotes'])->name('update.note');
});

// CHECKOUT
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::get('checkout-tanpa-login', [CheckoutController::class, 'checkoutTanpaLogin'])->name('checkout.tanpalogin');
Route::post('payment', [CheckoutController::class, 'payment'])->name('payment');

// PAYMENT 
Route::prefix('payment')->group(function () {
    Route::get('/', [PaymentController::class, 'paymentPage'])->name('paymentPage');
    Route::get('/download-invoice', [PaymentController::class, 'downloadInvoice'])->name('download.invoice');
    Route::get('/download-qris', [PaymentController::class, 'downloadQrCode'])->name('download.qris');
    Route::post('/check-qris', [PaymentController::class, 'checkStatusQris'])->name('check.qris');
    Route::post('upload-bukti-pembayaran', [PaymentController::class, 'uploadTF'])->name('upload.pembayaran');
    Route::post('ganti-metode-pembayaran', [PaymentController::class, 'changePaymentMethod'])->name('change.payment');
});

// TRACKING ORDER 
Route::get('trackorder', [TrackingOrderController::class, 'index'])->name('track.order.w2p');
Route::get('tracking-order', [TrackingOrderController::class, 'index']);

// PROFILE 
Route::middleware(['auth'])->group(function () {
    Route::get('daftar-belanja', [ProfileController::class, 'index'])->name('profile');
    Route::post('save-review', [ProfileController::class, 'storeReview'])->name('store.review');

    Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('edit.profile');
    Route::post('save-profile', [ProfileController::class, 'saveProfile'])->name('save.profile');

    Route::get('edit-password', [ProfileController::class, 'editPassword'])->name('edit.password');
    Route::post('save-password', [ProfileController::class, 'savePassword'])->name('save.password');

    Route::get('edit-address', [ProfileController::class, 'editAddress'])->name('edit.address');
    Route::post('save-address', [ProfileController::class, 'saveAddress'])->name('save.address');
    Route::post('ajax/get-city', [ProfileController::class, 'ajaxGetCity']);
    Route::post('ajax/get-suburb', [ProfileController::class, 'ajaxGetSuburb']);
    Route::post('ajax/get-suburb', [ProfileController::class, 'ajaxGetSuburb']);

    Route::get('design-studio', [ProfileController::class, 'designStudio'])->name('design.studio');
});

// QUEUE ONLINE-
Route::middleware(['auth'])->group(function () {
    Route::get('antrian-online', [QueueOnlineController::class, 'index'])->name('queue.online');
    Route::post('get-antrian-online', [QueueOnlineController::class, 'getQueue'])->name('get.queue');
});

Route::get('adminidp', function () {
    return redirect()->away('https://admin.indoprinting.co.id');
});

Route::get('test-wa', function () {
    $wa = waBeforePaid("INV-2022/01/1221", "089675465400", "Test WA");
    return $wa ?? "Gagal";
});

Route::get('daily-visit', function () {
    for ($i = 0; $i < 100; $i++) {
        visitorToday();
    }
    return "DONE";
});

Route::get('pengunjung-kemarin', function () {
    for ($i = 0; $i < 100; $i++) {
        visitorTomorrow();
    }
    return "DONE";
});

Route::get('clear-cache', function () {
    Artisan::call('cache:clear');
    return back();
})->name('clear.cache');
Route::get('optimize', function () {
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    return Artisan::call('view:cache');
});

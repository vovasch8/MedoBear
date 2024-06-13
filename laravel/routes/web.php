<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NovaPoshtaController;
use App\Http\Controllers\UkrPoshtaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::name('site.')->group(function () {
    Route::get('/', [SiteController::class, 'showCatalog'])->name('catalog');
    Route::get('/categories/{id}', [SiteController::class, 'showCatalog'])->name('current_catalog');
    Route::get('/product/{id}/{size}', [SiteController::class, 'showProduct'])->name('product');
    Route::get('/delivery', [SiteController::class, 'showDelivery'])->name('delivery');
    Route::get('/contacts', [SiteController::class, 'showContacts'])->name('contacts');
    Route::get('/about-us', [SiteController::class, 'showAbout'])->name('about_us');
    Route::post('/handle-message', [SiteController::class, 'sendMessage'])->name('send_message');
    Route::post('/apply-filters', [SiteController::class, 'applyFilters'])->name('filters');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
});

Route::name('cart.')->group(function () {
    Route::post('/add-product', [CartController::class, 'addProduct'])->name('add_product');
    Route::post('/delete-product', [CartController::class, 'deleteProduct'])->name('delete_product');
    Route::post('/add-promocode', [CartController::class, 'addPromocode'])->name('add_promocode');
});

Route::name('post.')->group(function () {
    Route::post('/get-cities', [NovaPoshtaController::class, 'getCities'])->name('get_cities');
    Route::post('/get-warehouses', [NovaPoshtaController::class, 'getWarehouses'])->name('get_warehouses');

    Route::post('/get-ukr-poshta-cities', [UkrPoshtaController::class, 'getCities'])->name('get_ukr_poshta_cities');
    Route::post('/get-post-offices', [UkrPoshtaController::class, 'getPostOffices'])->name('get_post_offices');
});

Route::name('order.')->group(function () {
    Route::post('/create-order', [OrderController::class, 'createOrder'])->name('create_order');
    Route::post('/update-order', [OrderController::class, 'updateOrder'])->name('update_order');
    Route::post('/get-order-products', [OrderController::class, 'getOrderProducts'])->name('get_order_products');
    Route::post('/get-order-cart', [OrderController::class, 'getOrderCart'])->name('get_order_cart');
});

require __DIR__.'/auth.php';
require __DIR__.'/cabinet.php';
require __DIR__.'/partner.php';
require __DIR__.'/admin.php';

Route::fallback(function () {
   return view("404");
})->name("404");

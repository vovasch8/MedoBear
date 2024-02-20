<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', [\App\Http\Controllers\SiteController::class, 'showCatalog'])->name('catalog');
Route::get('/category/{id}', [\App\Http\Controllers\SiteController::class, 'showCatalog'])->name('currentCatalog');
Route::get('/product/{id}', [\App\Http\Controllers\SiteController::class, 'showProduct'])->name('product');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'showCart'])->name('cart');

Route::post('/addProduct', [\App\Http\Controllers\CartController::class, 'addProduct'])->name('addProduct');
Route::post('/deleteProduct', [\App\Http\Controllers\CartController::class, 'deleteProduct'])->name('deleteProduct');

Route::post('/getCities', [\App\Http\Controllers\NovaPoshtaController::class, 'getCities'])->name('getCities');
Route::post('/getWarehouses', [\App\Http\Controllers\NovaPoshtaController::class, 'getWarehouses'])->name('getWarehouses');

Route::post('/getUkrPoshtaCities', [\App\Http\Controllers\UkrPoshtaController::class, 'getCities'])->name('getUkrPoshtaCities');
Route::post('/getPostOffices', [\App\Http\Controllers\UkrPoshtaController::class, 'getPostOffices'])->name('getPostOffices');

Route::post('/addPromocode', [\App\Http\Controllers\CartController::class, 'addPromocode'])->name('addPromocode');

Route::post('/createOrder', [\App\Http\Controllers\OrderController::class, 'createOrder'])->name('createOrder');
Route::post('/getOrderProducts', [\App\Http\Controllers\OrderController::class, 'getOrderProducts'])->name('getOrderProducts');

Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/admin-charts', [\App\Http\Controllers\AdminController::class, 'charts'])->name('admin-charts');
Route::get('/admin-tables', [\App\Http\Controllers\AdminController::class, 'tables'])->name('admin-tables');

Route::post('/admin-add-category', [\App\Http\Controllers\CategoryController::class, 'addCategory'])->name('addCategory');
Route::post('/admin-add-product', [\App\Http\Controllers\ProductController::class, 'addProduct'])->name('addProduct');
Route::post('/admin-add-product-to-order', [\App\Http\Controllers\OrderController::class, 'addProductToOrder'])->name('addProductToOrder');
Route::post('/admin-remove-product-from-order', [\App\Http\Controllers\OrderController::class, 'removeProductFromOrder'])->name('removeProductFromOrder');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

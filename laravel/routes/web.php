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
Route::get('category/{id}', [\App\Http\Controllers\SiteController::class, 'showCatalog'])->name('currentCatalog');
Route::get('product/{id}', [\App\Http\Controllers\SiteController::class, 'showProduct'])->name('product');
Route::get('cart', [\App\Http\Controllers\CartController::class, 'showCart'])->name('cart');

Route::post('/addProduct', [\App\Http\Controllers\CartController::class, 'addProduct'])->name('addProduct');
Route::post('/deleteProduct', [\App\Http\Controllers\CartController::class, 'deleteProduct'])->name('deleteProduct');

Route::post('/getCities', [\App\Http\Controllers\NovaPoshtaController::class, 'getCities'])->name('getCities');
Route::post('/getWarehouses', [\App\Http\Controllers\NovaPoshtaController::class, 'getWarehouses'])->name('getWarehouses');

Route::post('/addPromocode', [\App\Http\Controllers\CartController::class, 'addPromocode'])->name('addPromocode');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

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
Route::get('/partnership', [\App\Http\Controllers\SiteController::class, 'showPartnership'])->name('partnership');
Route::get('/contacts', [\App\Http\Controllers\SiteController::class, 'showContacts'])->name('contacts');
Route::post('/handle-message', [\App\Http\Controllers\SiteController::class, 'sendMessage'])->name('sendMessage');
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

Route::get('/dashboard', [\App\Http\Controllers\CabinetController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/admin-charts', [\App\Http\Controllers\AdminController::class, 'charts'])->name('admin-charts');
    Route::get('/admin-tables', [\App\Http\Controllers\AdminController::class, 'tables'])->name('admin-tables');

    Route::post('/admin-add-category', [\App\Http\Controllers\CategoryController::class, 'addCategory'])->name('addCategory');
    Route::post('/admin-add-product', [\App\Http\Controllers\ProductController::class, 'addProduct'])->name('addProduct');
    Route::post('/admin-add-product-to-order', [\App\Http\Controllers\OrderController::class, 'addProductToOrder'])->name('addProductToOrder');
    Route::post('/admin-remove-product-from-order', [\App\Http\Controllers\OrderController::class, 'removeProductFromOrder'])->name('removeProductFromOrder');

    Route::get('/admin-products-table', [\App\Http\Controllers\AdminController::class, 'productsTable'])->name('productsTable');
    Route::post('/admin-product-status', [\App\Http\Controllers\ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
    Route::post('/admin-product-category', [\App\Http\Controllers\ProductController::class, 'changeProductCategory'])->name('changeProductCategory');
    Route::post('/admin-product-move-to', [\App\Http\Controllers\ProductController::class, 'movePhotoProduct'])->name('movePhotoProduct');
    Route::post('/admin-product-add-photo', [\App\Http\Controllers\ProductController::class, 'addPhotoProduct'])->name('addPhotoProduct');
    Route::post('/admin-product-remove photo', [\App\Http\Controllers\ProductController::class, 'removePhotoProduct'])->name('removePhotoProduct');
    Route::get('/admin-messages-table', [\App\Http\Controllers\AdminController::class, 'messagesTable'])->name('messagesTable');
    Route::get('/admin-categories-table', [\App\Http\Controllers\AdminController::class, 'categoriesTable'])->name('categoriesTable');
    Route::post('/admin-category-status', [\App\Http\Controllers\CategoryController::class, 'changeCategoryStatus'])->name('changeCategoryStatus');
    Route::post('/admin-category-icon', [\App\Http\Controllers\CategoryController::class, 'updateCategoryImage'])->name('updateCategoryImage');
    Route::get('/admin-users-table', [\App\Http\Controllers\AdminController::class, 'usersTable'])->name('usersTable');
    Route::post('/admin-user-role', [\App\Http\Controllers\UserController::class, 'changeUserRole'])->name('changeUserRole');

    Route::post('/admin-edit-table-column', [\App\Http\Controllers\AdminController::class, 'editColumnTable'])->name('editColumnTable');
});

require __DIR__.'/auth.php';

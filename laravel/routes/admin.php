<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::middleware('auth')->group(function () {

    Route::name('admin.')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin');
        Route::get('/admin/charts', [AdminController::class, 'showCharts'])->name('charts');
        Route::get('/admin/tables', [AdminController::class, 'showTables'])->name('tables');
    });

    Route::name('admin_tables.')->group(function () {
        Route::get('/admin/products', [AdminController::class, 'showProducts'])->name('show_products');
        Route::get('/admin/messages', [AdminController::class, 'showMessages'])->name('show_messages');
        Route::get('/admin/promocodes', [AdminController::class, 'showPromocodes'])->name('show_promocodes');
        Route::get('/admin/categories', [AdminController::class, 'showCategories'])->name('show_categories');
        Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('show_users');

        Route::post('/admin/edit-table-column', [AdminController::class, 'editColumnTable'])->name('edit_column_table');
    });

    Route::name('admin_products.')->group(function () {
        Route::post('/admin/product-status', [ProductController::class, 'changeProductStatus'])->name('change_product_status');
        Route::post('/admin/product-category', [ProductController::class, 'changeProductCategory'])->name('change_product_category');
        Route::post('/admin/product-move-photo', [ProductController::class, 'movePhotoProduct'])->name('move_photo_product');
        Route::post('/admin/product-add-photo', [ProductController::class, 'addPhotoProduct'])->name('add_photo_product');
        Route::post('/admin/product-remove-photo', [ProductController::class, 'removePhotoProduct'])->name('remove_photo_product');
        Route::post('/admin/product-edit-description', [ProductController::class, 'editDescription'])->name("edit_description");

        Route::post('/admin/add-product', [ProductController::class, 'addProduct'])->name('add_product');
        Route::post('/admin/delete-product', [ProductController::class, 'deleteProduct'])->name('delete_product');
    });

    Route::name('admin_categories.')->group(function () {
        Route::post('/admin/category-status', [CategoryController::class, 'changeCategoryStatus'])->name('change_category_status');
        Route::post('/admin/category-icon', [CategoryController::class, 'updateCategoryImage'])->name('update_category_image');

        Route::post('/admin/add-category', [CategoryController::class, 'addCategory'])->name('add_category');
        Route::post('/admin/delete-category', [CategoryController::class, 'deleteCategory'])->name('delete_category');
    });

    Route::name('admin_users.')->group(function () {
        Route::post('/admin/user-role', [UserController::class, 'changeUserRole'])->name('change_user_role');
    });

    Route::name('admin_orders.')->group(function () {
        Route::post('/admin/add-product-to-order', [OrderController::class, 'addProductToOrder'])->name('add_product_to_order');
        Route::post('/admin/remove-product-from-order', [OrderController::class, 'removeProductFromOrder'])->name('remove_product_from_order');
        Route::post('/admin/delete-order', [OrderController::class, 'deleteOrder'])->name('delete_order');
    });

    Route::name('admin_messages.')->group(function () {
        Route::post('/admin/delete-message', [MessageController::class, 'deleteMessage'])->name('delete_message');
    });
});

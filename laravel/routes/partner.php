<?php

use App\Http\Controllers\PartnerController;

Route::name('partner.')->group(function () {
    Route::get('/partner', [PartnerController::class, 'partner'])->middleware(['auth', 'verified'])->name('partner');
    Route::post('/show-orders', [PartnerController::class, 'showOrders'])->middleware(['auth', 'verified'])->name('show_orders');
    Route::post('/save-card', [PartnerController::class, 'saveCard'])->middleware(['auth', 'verified'])->name('save_card');
    Route::post('/save-group', [PartnerController::class, 'saveGroup'])->middleware(['auth', 'verified'])->name('save_group');
});

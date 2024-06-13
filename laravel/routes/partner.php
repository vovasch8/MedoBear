<?php

use App\Http\Controllers\PartnerController;

Route::name('partner.')->group(function () {
    Route::get('/partner', [PartnerController::class, 'partner'])->middleware(['auth', 'verified'])->name('partner');
    Route::post('/save-card', [PartnerController::class, 'saveCard'])->middleware(['auth', 'verified'])->name('save_card');
});

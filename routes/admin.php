<?php

use Dealskoo\Affiliate\Http\Controllers\Admin\AffiliateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'admin_locale'])->prefix(config('admin.route.prefix'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

    });

    Route::middleware(['auth:admin', 'admin_active'])->group(function () {
        Route::resource('affiliates', AffiliateController::class)->except(['create', 'store', 'destroy']);
    });

});

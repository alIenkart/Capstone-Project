<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackagesController;
use App\Http\Controllers\Api\VoucherController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;

Route::middleware('api')->group(function () {
    Route::apiResource('packages', PackagesController::class);
    Route::apiResource('vouchers', VoucherController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('payments', PaymentController::class);
});

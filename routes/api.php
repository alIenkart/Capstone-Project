<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PackagesController;
use App\Http\Controllers\Api\VoucherController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\InquiryController;

Route::middleware('api')->group(function () {

    Route::get('bookings/by-user', [BookingController::class, 'getBookingsByUser']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('packages', PackagesController::class);
    Route::apiResource('vouchers', VoucherController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('inquiries', InquiryController::class);
});

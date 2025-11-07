<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PackagesController;
use App\Http\Controllers\Api\VoucherController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\TravelBlogController;

Route::middleware('api')->group(function () {

    Route::get('bookings/by-user', [BookingController::class, 'getBookingsByUser']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('packages', PackagesController::class);
    Route::apiResource('vouchers', VoucherController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('inquiries', InquiryController::class);
    Route::apiResource('feedbacks', FeedbackController::class);

    Route::apiResource('contents', ContentController::class);
    Route::post('contents/{content}/upload-image', [ContentController::class, 'uploadImage']);

    // Travel Blogs
    Route::apiResource('travel-blogs', TravelBlogController::class);
    Route::post('travel-blogs/{travel_blog}/upload-image', [TravelBlogController::class, 'uploadImage']);
});
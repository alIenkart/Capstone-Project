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
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\OurStoryController;
use App\Http\Controllers\Api\AccreditationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Api\ReceiptController;

Route::middleware('api')->group(function () {

    Route::get('bookings/by-user', [BookingController::class, 'getBookingsByUser']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('packages', PackagesController::class);
    Route::put('packages/{id}/seasonal-pricing', [PackagesController::class, 'updateSeasonalPricing']);
    Route::put('packages/{id}/deactivate-seasonal', [PackagesController::class, 'deactivateSeasonalPricing']);
    
    Route::apiResource('vouchers', VoucherController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('inquiries', InquiryController::class);
    Route::apiResource('feedbacks', FeedbackController::class);
     // Contents

    Route::apiResource('contents', ContentController::class);
    Route::post('contents/{content}/upload-image', [ContentController::class, 'uploadImage']);

    // Travel Blogs
    Route::apiResource('travel-blogs', TravelBlogController::class);
    Route::post('travel-blogs/{travel_blog}/upload-image', [TravelBlogController::class, 'uploadImage']);

    Route::get('about-us', [AboutUsController::class, 'index']);
    Route::patch('about-us', [AboutUsController::class, 'update']);
    Route::post('about-us/upload-image', [AboutUsController::class, 'uploadImage']);

    Route::get('our-story', [OurStoryController::class, 'index']);
    Route::patch('our-story', [OurStoryController::class, 'update']);
    Route::post('our-story/upload-image', [OurStoryController::class, 'uploadImage']);

    Route::apiResource('accreditations', AccreditationController::class, ['only' => ['index', 'store', 'destroy']]);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/unread', [NotificationController::class, 'unread']);
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);

    Route::patch('packages/{id}/toggle-status', [PackagesController::class, 'toggleStatus']);
    Route::get('analytics', [AnalyticsController::class, 'index']);

});

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::apiResource('receipts', ReceiptController::class);
    Route::apiResource('payments', PaymentController::class);
});
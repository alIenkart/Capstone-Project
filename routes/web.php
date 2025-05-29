<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Home
Route::get('/home', function () {
    return Inertia::render('Landing/Home');
})->name('home');

// Destinations
Route::get('/destination', function () {
    return Inertia::render('Landing/Destination');
})->name('destination');

// Blogs
Route::get('/blogs', function () {
    return Inertia::render('Landing/Blogs');
})->name('blogs');

// About Us
Route::get('/aboutus', function () {
    return Inertia::render('Landing/Aboutus');
})->name('aboutus');

// Contact Us
Route::get('/contactus', function () {
    return Inertia::render('Landing/Contactus');
})->name('contactus');

// Profile
Route::get('/profile', function () {
    return Inertia::render('Landing/Profile');
})->name('profile');

// Your Bookings
Route::get('/yourbookings', function () {
    return Inertia::render('Landing/Yourbookings');
})->name('yourbookings');

// Notitications
Route::get('/notifications', function () {
    return Inertia::render('Landing/Notifications');
})->name('notifications');

// Admin Dashboard
Route::get('/admin/admindashboard', function () {
    return Inertia::render('Admin/AdminDashboard');
})->name('admin.admindashboard');

// Packages
Route::get('/admin/packages', function () {
    return Inertia::render('Admin/Packages');
})->name('admin.packages');

// Booking Entries
Route::get('/admin/booking-entries', function () {
    return Inertia::render('Admin/BookingEntries');
})->name('admin.booking-entries');

// Payment Confirmation
Route::get('/admin/payment-confirmation', function () {
    return Inertia::render('Admin/PaymentConfirmation');
})->name('admin.payment-confirmation');

// Content Management
Route::get('/admin/content-management', function () {
    return Inertia::render('Admin/ContentManagement');
})->name('admin.content-management');

// Review & Feedback
Route::get('/admin/review-feedback', function () {
    return Inertia::render('Admin/ReviewFeedback');
})->name('admin.review-feedback');

// Settings
Route::get('/admin/settings', function () {
    return Inertia::render('Admin/Settings');
})->name('admin.settings');
require __DIR__.'/auth.php';

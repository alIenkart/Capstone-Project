<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Auth\OtpRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginHistoryController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing/Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/yourbookings', function () {
        return Inertia::render('Landing/Yourbookings');
    })->name('yourbookings');

    Route::get('/notifications', function () {
        return Inertia::render('Landing/Notifications');
    })->name('notifications');

    Route::get('/process-booking/{id}', function ($id) {
        return Inertia::render('Landing/ProcessBooking', [
            'id' => $id,
        ]);
    })->name('process-booking');

    Route::get('/calendar', function () {
        return Inertia::render('Landing/Calendar');
    })->name('calendar');

    Route::get('/selectpackage', function () {
        return Inertia::render('Landing/SelectPackage');
    })->name('selectpackage');

    Route::get('/bookingconfirmation', function () {
        return Inertia::render('Landing/BookingConfirmation');
    })->name('bookingconfirmation');
});

Route::get('/home', function () {
    return Inertia::render('Landing/Home');
})->name('home');

Route::get('/destination', function () {
    return Inertia::render('Landing/Destination');
})->name('destination');

Route::get('/blogs', function () {
    return Inertia::render('Landing/Blogs');
})->name('blogs');

Route::get('/aboutus', function () {
    return Inertia::render('Landing/Aboutus');
})->name('aboutus');

Route::get('/contactus', function () {
    return Inertia::render('Landing/Contactus');
})->name('contactus');

Route::get('/tourdetails/{id}', function ($id) {
    return Inertia::render('Landing/Tourdetails', [
        'id' => $id
    ]);
})->name('tourdetails');

Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::get('/admin/admindashboard', function () {
        return Inertia::render('Admin/AdminDashboard');
    })->name('admin.admindashboard');

    Route::get('/admin/users', function () {
        return Inertia::render('Admin/UserList');
    })->name('admin.users');

    Route::get('/admin/packages', function () {
        return Inertia::render('Admin/Packages');
    })->name('admin.packages');

    Route::get('/admin/booking-entries', function () {
        return Inertia::render('Admin/BookingEntries');
    })->name('admin.booking-entries');

    Route::get('/admin/payment-confirmation', function () {
        return Inertia::render('Admin/PaymentConfirmation');
    })->name('admin.payment-confirmation');

    Route::get('/admin/content-management', function () {
        return Inertia::render('Admin/ContentManagement');
    })->name('admin.content-management');
    
    Route::get('/admin/payment-configuration', function () {
        return Inertia::render('Admin/PaymentManagement');
    })->name('admin.payment-management');

    Route::get('/admin/automation-settings', function () {
        return Inertia::render('Admin/AutomationSettings');
    })->name('admin.automation-settings');

    Route::get('/admin/review-feedback', function () {
        return Inertia::render('Admin/ReviewFeedback');
    })->name('admin.review-feedback');

    Route::get('/admin/login-history', [AdminLoginHistoryController::class, 'index'])
    ->name('admin.login-history');

    Route::get('/admin/settings', function () {
        return Inertia::render('Admin/Settings');
    })->name('admin.settings');
});

Route::post('/send-otp', [OtpRegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/verify-otp', [OtpRegisterController::class, 'verifyOtp'])->name('otp.verify');

require __DIR__ . '/auth.php';

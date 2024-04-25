<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

Route::middleware(['guest:admin_users'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

// Routes for authentication
Route::middleware(['guest:admin_users'])->group(function () {
    Route::get('register', [AdminAuthController::class, 'register'])->name('register');
    Route::post('register', [AdminAuthController::class, 'registerSave'])->name('register.save');
    Route::get('login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthController::class, 'loginAction'])->name('login.action');
});

// Routes for authenticated admin users
Route::middleware(['auth:admin_users'])->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('profile', [AdminAuthController::class, 'profile'])->name('profile');

    // Booking routes
    Route::get('/admin/bookings', [AdminAuthController::class, 'showBookings'])->name('admin.bookings');
    Route::put('/admin/bookings/{id}', [AdminAuthController::class, 'updateBookingStatus'])->name('admin.bookings.update');
    Route::get('/admin/bookings/approved', [AdminAuthController::class, 'showApprovedBookings'])->name('admin.bookings.approved');
    Route::get('/admin/bookings/rejected', [AdminAuthController::class, 'showRejectedBookings'])->name('admin.bookings.rejected');

    // Service management routes
    Route::get('/admin/services', [AdminAuthController::class, 'showServices'])->name('admin.services');
    Route::get('/admin/services/create', [AdminAuthController::class, 'createService'])->name('admin.services.create');
    Route::post('/admin/services/store', [AdminAuthController::class, 'storeService'])->name('admin.services.store');
    Route::get('/admin/services/edit/{id}', [AdminAuthController::class, 'editService'])->name('admin.services.edit');
    Route::put('/admin/services/update/{id}', [AdminAuthController::class, 'updateService'])->name('admin.services.update');
    Route::delete('/admin/services/delete/{id}', [AdminAuthController::class, 'deleteService'])->name('admin.services.delete');
    Route::delete('/admin/services/soft-delete/{id}', [AdminAuthController::class, 'softDeleteService'])->name('admin.services.soft-delete');
    Route::post('/admin/services/restore/{id}', [AdminAuthController::class, 'restoreService'])->name('admin.services.restore');
    Route::delete('/admin/services/delete-permanently/{id}', [AdminAuthController::class, 'deletePermanentlyService'])->name('admin.services.delete-permanently');
});

// Additional dashboard route for authenticated admin users
Route::middleware(['auth:admin_users'])->group(function () {
    Route::get('dashboard', function () {
        $adminAuthController = new AdminAuthController();
        $bookingCounts = $adminAuthController->getBookingCounts();
        return view('dashboard', compact('bookingCounts'));
    })->name('dashboard');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

Route::middleware(['guest:admin_users'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
//Route for displaying the forgot password form and sending reset link
Route::get('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/send-reset-link', [AdminAuthController::class, 'sendResetLink'])->name('send.reset.link');

// Route for displaying the password reset form
Route::get('/reset/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('password.reset');

// Route for handling the password reset
Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('reset.password');
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
    Route::middleware(['auth:admin_users'])->group(function () {
    Route::get('/admin/users', [AdminAuthController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminAuthController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminAuthController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminAuthController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminAuthController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminAuthController::class, 'destroy'])->name('admin.users.destroy');
    Route::delete('/admin/users/{id}/soft-delete', [AdminAuthController::class, 'softDelete'])->name('admin.users.soft-delete');
    Route::post('/admin/users/{id}/restore', [AdminAuthController::class, 'restore'])->name('admin.users.restore');
    Route::delete('/admin/users/delete-permanently/{id}', [AdminAuthController::class, 'deletePermanently'])->name('admin.users.delete-permanently');

});
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

    // Pet management routes
    Route::get('/admin/pets', [AdminAuthController::class, 'showPets'])->name('admin.pets');
    Route::get('/admin/pets/create', [AdminAuthController::class, 'createPet'])->name('admin.pets.create');
    Route::post('/admin/pets/store', [AdminAuthController::class, 'storePet'])->name('admin.pets.store');
    Route::get('/admin/pets/edit/{id}', [AdminAuthController::class, 'editPet'])->name('admin.pets.edit');
    Route::put('/admin/pets/update/{id}', [AdminAuthController::class, 'updatePet'])->name('admin.pets.update');
    Route::delete('/admin/pets/delete/{id}', [AdminAuthController::class, 'deletePet'])->name('admin.pets.delete');
    Route::delete('/admin/pets/soft-delete/{id}', [AdminAuthController::class, 'softDeletePet'])->name('admin.pets.soft-delete');
    Route::post('/admin/pets/restore/{id}', [AdminAuthController::class, 'restorePet'])->name('admin.pets.restore');
    Route::delete('/admin/pets/delete-permanently/{id}', [AdminAuthController::class, 'deletePermanentlyPet'])->name('admin.pets.delete-permanently');
});

// Additional dashboard route for authenticated admin users
Route::middleware(['auth:admin_users'])->group(function () {
    Route::get('dashboard', function () {
        $adminAuthController = new AdminAuthController();
        $bookingCounts = $adminAuthController->getBookingCounts();
        return view('dashboard', compact('bookingCounts'));
    })->name('dashboard');
});

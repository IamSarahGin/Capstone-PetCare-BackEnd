<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AdminAuthController::class)->group(function (){
    Route::get('register', [AdminAuthController::class, 'register'])->name('register');
    Route::post('register', [AdminAuthController::class, 'registerSave'])->name('register.save');
    Route::get('login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthController::class, 'loginAction'])->name('login.action');
    Route::post('logout',[AdminAuthController::class, 'logout'])->name('logout');   
});

Route::middleware('auth:admin_users')->group(function (){
    Route::get('dashboard', function(){
        return view('dashboard');
    })->name('dashboard');
    Route::get("/profile",[App\Http\Controllers\AdminAuthController::class, 'profile'])->name('profile');
    //pending booking
    Route::get('/admin/bookings', [AdminAuthController::class, 'showBookings'])->name('admin.bookings');
    Route::put('/admin/bookings/{id}', [AdminAuthController::class, 'updateBookingStatus'])->name('admin.bookings.update');
    //approved booking
    Route::get('/admin/bookings/approved', [AdminAuthController::class, 'showApprovedBookings'])->name('admin.bookings.approved');
    //rejected booking
    Route::get('/admin/bookings/rejected', [AdminAuthController::class, 'showRejectedBookings'])->name('admin.bookings.rejected');

});

Route::middleware('auth:admin_users')->group(function () {
     // Service management routes
    Route::get('/admin/services', [AdminAuthController::class, 'showServices'])->name('admin.services');
    Route::get('/admin/services/create', [AdminAuthController::class, 'createService'])->name('admin.services.create');
    Route::post('/admin/services/store', [AdminAuthController::class, 'storeService'])->name('admin.services.store');
    Route::get('/admin/services/edit/{id}', [AdminAuthController::class, 'editService'])->name('admin.services.edit');
    Route::put('/admin/services/update/{id}', [AdminAuthController::class, 'updateService'])->name('admin.services.update');
    Route::delete('/admin/services/delete/{id}', [AdminAuthController::class, 'deleteService'])->name('admin.services.delete');
    Route::delete('/admin/services/soft-delete/{id}', [AdminAuthController::class, 'softDeleteService'])->name('admin.services.soft-delete'); // Define soft delete route here
    Route::post('/admin/services/restore/{id}', [AdminAuthController::class, 'restoreService'])->name('admin.services.restore'); // Define restore route here
    Route::delete('/admin/services/delete-permanently/{id}', [AdminAuthController::class, 'deletePermanentlyService'])->name('admin.services.delete-permanently'); // Define permanent delete route
});

Route::middleware('auth:admin_users')->group(function (){
    Route::get('dashboard', function(){
        $adminAuthController = new AdminAuthController();
        $bookingCounts = $adminAuthController->getBookingCounts();
        return view('dashboard', compact('bookingCounts'));
    })->name('dashboard');
});
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

    Route::get('logout',[AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

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

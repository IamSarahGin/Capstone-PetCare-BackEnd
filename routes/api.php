<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\TimeSlotController;
/*
|--------------------------------------------------------------------------
| Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//login route
Route::post('/login',[AuthController::class,'Login']);
//register route
Route::post('/register',[AuthController::class,'Register']);
//forgot password route
Route::post('/forgetpassword',[ForgotController::class,'ForgetPassword']);
//reset password route
Route::post('/resetpassword',[ResetController::class,'ResetPassword']);
//get user route
//use middleware to check if the user is logged
Route::get('/user',[UserController::class,'User'])->middleware('auth:api');

//booking
Route::middleware('auth:api')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
});

// CRUD operations on pets
Route::get('/pets', [PetController::class, 'index']); // Retrieve all pets
Route::post('/pets', [PetController::class, 'store']); // Create a new pet
Route::get('/pets/{id}', [PetController::class, 'show']); // Retrieve a specific pet
Route::put('/pets/{id}', [PetController::class, 'update']); // Update a pet
Route::delete('/pets/{id}', [PetController::class, 'destroy']); // Delete a pet


Route::middleware('auth:api')->group(function () {
    Route::get('/time-slots', [TimeSlotController::class, 'index']);
Route::post('/time-slots', [TimeSlotController::class, 'store']);
Route::put('/time-slots/{id}', [TimeSlotController::class, 'update']);
Route::delete('/time-slots/{id}', [TimeSlotController::class, 'destroy']);
});
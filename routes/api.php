<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\BookingController;
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
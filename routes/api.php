<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth for student
Route::post("/login-student", [AuthController::class, 'LoginForStudent']);
Route::post("/forgot-password-student", [AuthController::class, 'ForgotPasswordStudent']);
Route::post("/verify-otp-student", [AuthController::class, 'VerifyOTPStudent']);
Route::post("/reset-password-student", [AuthController::class, 'ResetPasswordStudent']);

//auth for officer
Route::post("/login-officer", [AuthController::class, 'LoginForOfficer']);
Route::post("/forgot-password-officer", [AuthController::class, 'ForgotPasswordOfficer']);
Route::post("/verify-otp-officer", [AuthController::class, 'VerifyOTPOfficer']);
Route::post("/reset-password-officer", [AuthController::class, 'ResetPasswordOfficer']);

Route::middleware(['auth:sanctum', 'ability:access-token'])->group(function () {
    Route::get("/me", [AuthController::class, 'Me']);

    Route::get("/bill-spp-student/{id}", [BillController::class, 'index'])->where('id','[0-9]+');
    
    Route::middleware(['role:admin'])->group(function () {

    });

    Route::middleware(['role:officer'])->group(function () {});
});
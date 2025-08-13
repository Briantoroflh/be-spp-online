<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, 'Login']);
Route::post("/forgot-password", [AuthController::class, 'ForgotPassword']);
Route::post("/verify-otp", [AuthController::class, 'VerifyOTP']);
Route::post("/reset-password", [AuthController::class, 'ResetPassword']);

Route::middleware(['auth:sanctum', 'ability:access-token'])->group(function () {
    Route::get("/me", [AuthController::class, 'Me']);

    Route::middleware(['role:admin'])->group(function () {

    });

    Route::middleware(['role:officer'])->group(function () {});

    Route::middleware(['role:student'])->group(function () {
        Route::get("/bill-spp-student/{id}", [BillController::class, 'index'])->where('id','[0-9]+');
    });
});
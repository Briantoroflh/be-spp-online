<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\ManageOfficerController;
use App\Http\Controllers\Api\ManageSppController;
use App\Http\Controllers\Api\ManageStudentController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth for student mobile or web
Route::post("/login-student", [AuthController::class, 'LoginForStudent']);
Route::post("/forgot-password-student", [AuthController::class, 'ForgotPasswordStudent']);
Route::post("/verify-otp-student", [AuthController::class, 'VerifyOTPStudent']);
Route::post("/reset-password-student", [AuthController::class, 'ResetPasswordStudent']);

//auth for officer web
Route::post("/login-officer", [AuthController::class, 'LoginForOfficer']);
Route::post("/forgot-password-officer", [AuthController::class, 'ForgotPasswordOfficer']);
Route::post("/verify-otp-officer", [AuthController::class, 'VerifyOTPOfficer']);
Route::post("/reset-password-officer", [AuthController::class, 'ResetPasswordOfficer']);

Route::middleware(['auth:sanctum', 'ability:access-token'])->group(function () {
    Route::get("/me", [AuthController::class, 'Me']);

    Route::get("/bill-spp-student/{id}", [BillController::class, 'index']);
    Route::get("/bill-spp-student/{idBill}/{idStudent}", [BillController::class, 'show']);
    Route::post("/payment", [PaymentController::class, 'store']);
    
    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource("/spp", [ManageSppController::class]);
        Route::apiResource("/student", [ManageStudentController::class]);
        Route::apiResource("/officer", [ManageOfficerController::class]);
    });

    Route::middleware(['role:officer'])->group(function () {
        Route::post("/create-bill-student", [BillController::class, 'store']);
        Route::post("/update-bill-student", [BillController::class, 'update']);
        Route::post("/delete-bill-student", [BillController::class, 'destroy']);
    });
});
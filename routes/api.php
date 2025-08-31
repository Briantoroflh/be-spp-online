<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\CurrentBillController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DetailBillController;
use App\Http\Controllers\Api\ManageOfficerController;
use App\Http\Controllers\Api\ManageSppController;
use App\Http\Controllers\Api\ManageStudentController;
use App\Http\Controllers\Api\OfficerController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StudentController;
use App\Models\CurrentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Officer Authentication
Route::post('/officer/login', [AuthController::class, 'officerLogin']);
Route::post('/officer/forgot-password', [AuthController::class, 'officerForgotPassword']);
Route::post('/officer/verify-otp', [AuthController::class, 'officerVerifyOTP']);
Route::post('/officer/reset-password', [AuthController::class, 'officerResetPassword']);

//Student Authentication
Route::post('/student/login', [AuthController::class, 'studentLogin']);
Route::post('/student/forgot-password', [AuthController::class, 'studentForgotPassword']);
Route::post('/student/verify-otp', [AuthController::class, 'studentVerifyOTP']);
Route::post('/student/reset-password', [AuthController::class, 'studentResetPassword']);

Route::middleware(['auth:sanctum', 'ability:access-token'])->group(function () {

    Route::get('/current-bill/{id}', [CurrentBillController::class, 'getCurrentBillByUuidStudent']);
    Route::get('/detail-bill', [DetailBillController::class. '']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('/student', StudentController::class);
        Route::apiResource('/role', RoleController::class);
        Route::apiResource('/officer', OfficerController::class);
    });

    Route::middleware('role:tu')->group(function () {
        Route::apiResource('/bill', BillController::class);
        Route::apiResource('/detail-bill', DetailBillController::class);
    });
});
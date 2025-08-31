<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordReq;
use App\Http\Requests\Auth\LoginForOfficerReq;
use App\Http\Requests\Auth\LoginForStudentReq;
use App\Http\Requests\Auth\ResetPasswordReq;
use App\Http\Requests\Auth\VerifyOTPReq;
use App\Http\Resources\OfficerLoginRes;
use App\Mail\ResetPasswordMail;
use App\Models\Officer;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function officerLogin(LoginForOfficerReq $req)
    {
        $validated = $req->validated();

        $officer = Officer::where('username', $validated['username'])->first();

        if (!$officer) {
            return ApiRes::errorResponse("Officer dengan username {$validated['username']} tidak ditemukan", null, 404);
        }

        if (!Hash::check($validated['password'], $officer->password)) {
            return ApiRes::errorResponse('Pastikan password dan email anda benar!', null, 401);
        }

        $accessToken = $officer->createToken(config('app.api_key'), ['access-token']);
        $accessToken->accessToken->expires_at = now()->addWeek(1);
        $accessToken->accessToken->save();

        return ApiRes::successResponse("Berhasil login, Halo {$officer->username}", new OfficerLoginRes($officer, $accessToken->plainTextToken));
    }

    public function officerForgotPassword(ForgotPasswordReq $req)
    {
        $validated = $req->validated();

        $officer = Officer::where('email', $validated['email'])->first();

        if (!$officer) {
            return ApiRes::errorResponse("Officer dengan email {$validated['email']} tidak ditemukan", null, 404);
        }

        $otp = rand(1000, 9999);

        $officer->update([
            'code_otp' => $otp
        ]);

        Mail::to($validated['email'])->send(new ResetPasswordMail($otp, $officer));

        return ApiRes::successResponse("Otp berhasil terkirim!");
    }

    public function officerVerifyOTP(VerifyOTPReq $req)
    {
        $validated = $req->validated();

        $officer = Officer::where('email', $validated['email'])->first();

        if ($officer->code_otp != $validated['otp']) {
            return ApiRes::errorResponse("Kode otp yang anda masukan salah!");
        }

        return ApiRes::successResponse("Verifikasi kode otp berhasil!");
    }

    public function officerResetPassword(ResetPasswordReq $req)
    {
        $validated = $req->validated();

        $officer = Officer::where('email', $validated['email'])
            ->where('code_otp', $validated['otp'])->first();

        $officer->update(['password' => Hash::make($validated['password'])]);

        return ApiRes::successResponse("Reset password berhasil!");
    }

    public function studentLogin(LoginForStudentReq $req)
    {
        $validated = $req->validated();

        $student = Student::where('nisn', $validated['nisn'])->first();

        if (!$student) {
            return ApiRes::errorResponse("Student dengan NISN {$validated['nisn']} tidak ditemukan", null, 404);
        }

        if (!Hash::check($validated['password'], $student->password)) {
            return ApiRes::errorResponse('Pastikan password dan email anda benar!', null, 401);
        }

        $accessToken = $student->createToken(config('app.api_key'), ['access-token']);
        $accessToken->accessToken->expires_at = now()->addWeek(1);
        $accessToken->accessToken->save();

        return ApiRes::successResponse("Berhasil login, Halo {$student->name}", new OfficerLoginRes($student, $accessToken->plainTextToken));
    }

    public function studentForgotPassword(ForgotPasswordReq $req)
    {
        $validated = $req->validated();

        $student = Student::where('email', $validated['email'])->first();

        if (!$student) {
            return ApiRes::errorResponse("Student dengan email {$validated['email']} tidak ditemukan", null, 404);
        }

        $otp = rand(1000, 9999);

        $student->update([
            'code_otp' => $otp
        ]);

        Mail::to($validated['email'])->send(new ResetPasswordMail($otp, $student));

        return ApiRes::successResponse("Otp berhasil terkirim!");
    }

    public function studentVerifyOTP(VerifyOTPReq $req)
    {
        $validated = $req->validated();

        $student = Student::where('email', $validated['email'])->first();

        if ($student->code_otp != $validated['otp']) {
            return ApiRes::errorResponse("Kode otp yang anda masukan salah!");
        }

        return ApiRes::successResponse("Verifikasi kode otp berhasil!");
    }

    public function studentResetPassword(ResetPasswordReq $req)
    {
        $validated = $req->validated();

        $student = Student::where('email', $validated['email'])
            ->where('code_otp', $validated['otp'])->first();

        $student->update(['password' => Hash::make($validated['password'])]);

        return ApiRes::successResponse("Reset password berhasil!");
    }
}

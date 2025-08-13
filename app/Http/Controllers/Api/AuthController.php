<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginReq;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiRes;
use App\Http\Requests\Auth\ForgotPasswordReq;
use App\Http\Requests\Auth\ResetPasswordReq;
use App\Http\Requests\Auth\VerifyOTPReq;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function Login(LoginReq $req)
    {
        $validated = $req->validated();

        $user = User::where('email', $validated['email'])
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return ApiRes::error("Check your email or password again! make sure it's correct.", 404);
        }

        $at_expration = 60 * 24;
        $credential_token = $user->createToken(config("app.api_key"), ['access-token'], Carbon::now()->addMinutes($at_expration))
            ->plainTextToken;

        $at_refresh = 30 * 24 * 60;
        $refresh_token = $user->createToken(config("app.api_key"), ['refresh-token'], Carbon::now()->addMinutes($at_refresh))
            ->plainTextToken;

        return ApiRes::success($user, 'Login Success!', 200, $credential_token, $refresh_token);
    }

    public function Me()
    {
        $user = Auth::user();

        return ApiRes::success($user, "Data retrivied!");
    }

    public function RefreshToken(Request $req): JsonResponse
    {

        $user = $req->user();

        $at_expration = 60 * 24;
        $credential_token = $user->createToken(config("app.api_key"), ['access-token'], Carbon::now()->addMinutes($at_expration))
            ->plainTextToken;

        return ApiRes::success($credential_token, 'Refresh token success!');
    }

    public function ForgotPassword(ForgotPasswordReq $req) {
        $validated = $req->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['message' => "Email doesn't exists!"], 404);
        }

        $otp = rand(1000, 9999);

        $user->update([
            'code_otp' => $otp
        ]);

        Mail::to($validated['email'])->send(new ResetPasswordMail($otp, $user));

        return response()->json(['message' => 'Otp has been sent.'], 200);
    }

    public function VerifyOTP(VerifyOTPReq $req) {
        $validated = $req->validated();

        $user = User::where('email', $validated['email'])->first();

        if($user->code_otp != $validated['otp']){
            return response()->json(['message' => 'Wrong OTP code!'], 400);
        }

        return response()->json(['message' => 'OTP verified!'], 200);
    }

    public function ResetPassword(ResetPasswordReq $req) {
        $validated = $req->validated();

        $user = User::where('email', $validated['email'])
                ->where('code_otp', $validated['otp'])->first();

        $user->update(['password' => Hash::make($validated['password'])]);

        return response()->json(['message' => 'Reset password success!'], 200);
    }

    public function Logout(Request $req): JsonResponse
    {

        $user = $req->user()->tokens()->delete();

        return ApiRes::success($user, 'Logout success!');
    }
}

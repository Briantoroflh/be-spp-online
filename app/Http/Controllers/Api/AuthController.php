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

        return ApiRes::success($user, 'Login Success!');
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

    public function Logout(Request $req): JsonResponse
    {

        $user = $req->user()->tokens()->delete();

        return ApiRes::success($user, 'Logout success!');
    }
}

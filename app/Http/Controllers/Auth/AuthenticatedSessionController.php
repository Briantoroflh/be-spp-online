<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginStudentReq;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        $user->getRoleNames();

        $token = $user->createToken(config('app.api_key'))->plainTextToken;

        return ApiRes::successResponse("Login Berhasil", [
            $user,
            'token' => $token
        ]);
    }

    public function LoginStudent(LoginStudentReq $request)
    {
        $user = User::whereHas('student', function ($q) use ($request) {
            $q->where('nisn', $request->nisn);
        })->first();

        if (!$user) {
            return ApiRes::errorResponse("NISN tidak ditemukan", null, 401);
        }

        if (!Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            return ApiRes::errorResponse("Password salah", null, 401);
        }
        $request->session()->regenerate();

        $user->load('student');
        $user->getRoleNames();

        $token = $user->createToken(config('app.api_key'))->plainTextToken;

        return ApiRes::successResponse("Login Berhasil", [
            $user,
            'token' => $token
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}

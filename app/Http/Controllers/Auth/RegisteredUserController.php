<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string'],
            'photo' => ['nullable', 'mimes:jpg,png,jpeg', 'file']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->hasFile('photo')
                ? $request->file('photo')->store('img')
                : null,
        ]);

        $user->assignRole("School Admin");

        event(new Registered($user));

        Auth::login($user);

        return ApiRes::successResponse("Registrasi berhasil!", $user, 201);
    }
}

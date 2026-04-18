<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = (new User())->forceFill([
            'name'             => $data['name'],
            'email'            => $data['email'],
            'password'         => bcrypt($data['password']),
            'role'             => 'farmer',
            'onboarding_step'  => 1,
        ]);
        $user->save();

        Auth::login($user);

        return response()->json($user->toApiArray(), 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Neispravni podaci za prijavu.'], 401);
        }

        $request->session()->regenerate();

        $user = auth()->user()->load('farmerProfile.photos');

        return response()->json($user->toApiArray());
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Odjavljeni ste.']);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('farmerProfile.photos');
        return response()->json($user->toApiArray());
    }
}

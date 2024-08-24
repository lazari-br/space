<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->all())) {
            return response()->json(['message' => 'O email ou senha estão incorretos.'], 401);
        }

        $expiresAt = now()->addDay();
        $token = Auth::user()->createToken("API TOKEN", [], $expiresAt);

        return response()->json([
            'authenticate' => true,
            'expired_at' => $expiresAt,
            'token' => $token->plainTextToken,
            'user' => auth()->user(),
        ]);
    }
}

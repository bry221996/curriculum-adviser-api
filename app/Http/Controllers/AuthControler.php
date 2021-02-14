<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthControler extends Controller
{
    /**
     * Login exising user.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request): Response
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token =  $user->createToken($request->ip() . '|' . $request->header('User-Agent'))
            ->plainTextToken;

        return response([
            'status' => true,
            'data' => [
                'user' => $user,
                'access_token' => $token
            ]
        ]);
    }
}

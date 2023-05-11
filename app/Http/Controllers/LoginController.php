<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'User Logged In Successfully',
                'token' => Auth::user()->createToken("API TOKEN")->plainTextToken
            ], 200);
        }

        return response()->json(['message' => 'The email or password are incorrect.'], 422);
    }
}

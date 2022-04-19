<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'integer', 'min:6'],
        ]);

        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password
        ])) {

            $token = auth()->user()->createToken('key')->plainTextToken;
            return response()->json(['access_token' => $token]);
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed')
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'alpha'],
            'username' => ['required', 'alpha_dash', 'unique:users'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'integer', 'min:6'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('key')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }
}

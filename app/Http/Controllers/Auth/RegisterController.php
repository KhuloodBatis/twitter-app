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
            'mobile' => ['required', 'string', 'min:10'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username === null ? $request->username : $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('key')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }
}

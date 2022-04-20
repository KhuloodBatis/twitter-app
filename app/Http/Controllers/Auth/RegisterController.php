<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        $num4 = "00966";
        $lastNumMobile = $num4 . substr($data['mobile'], -9);
        $data['mobile'] = $lastNumMobile;


        $name   = explode(' ', $request->name); //the first name
        $num    = substr($data['mobile'], -4); //4 last number from mobile
        $random = Str::random(5); //5 random string
        $marks  = ['@', '$', '%', '#', '&', '*']; //random markes
        $newName = ($name[0] . $marks[array_rand($marks)] . $num . $random);
        $genUsername = $data['username'] ? $data['username'] : $newName;
        $data['username'] = $genUsername;

        Validator::make($data, [
            'name'     => ['required', 'string'],
            'username' => ['nullable', 'string', 'unique:users'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'mobile'   => ['required', 'string', 'min:10'],
            'password' => ['required', 'string', 'min:6'],
        ])->validate();

        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'mobile'   => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('key')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }
}

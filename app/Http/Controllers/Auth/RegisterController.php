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
        $data   = $request->all();
        $num1 = "5";
        $num2 = "0";
        $num3 = "966";
        $num4 = "00966";
        $lastNumMobile = substr($data['mobile'], -9);

        if (str_starts_with($data['mobile'], $num1)) {
            $data['mobile'] = $num4 . $lastNumMobile;
        } elseif (str_starts_with($data['mobile'], $num2)) {
            $data['mobile'] = $num4 . $lastNumMobile;
        } elseif (str_starts_with($data['mobile'], $num3)) {
            $data['mobile'] = $num4 . $lastNumMobile;
        } elseif (str_starts_with($data['mobile'], $num4)) {
            $data['mobile'] = $num4 . $lastNumMobile;
        }

        return  $data['mobile'];

        $name   = explode(' ', $request->name);
        $num    = substr($data['mobile'], 6);
        $random = Str::random(5);
        $marks  = ['@', '$', '%', '#', '&', '*'];
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Acount;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AcountController extends Controller
{
    public function store(Request $request)
    {

        // validate
        // name
        // username
        // mobile
        // $request->validate([
        //     'name' => ['required', 'string'],
        //     'username' => ['nullable', 'alpha_dash', 'unique:acounts'],
        //     'mobile' => ['required', 'string', 'min:10'],
        // ]);
        //1 way
        // $new_username = $request->name.Str::slug(Acount::max('id') + random_int(10,99));
        // $last_username = str_replace(" ","",$new_username); output //AliJawish79658
        //2 way
        //$r = strrev($request->name);output //hsiwaJ ilA
        //3 way
        // $query = "SELECT COUNT(id)FROM acounts WHERE username like '%".$request->name."%'";output//Ali JawishSELECT COUNT(id)  FROM acounts WHERE username like '%Ali Jawish%'
        //4way
        // $user_name = $request->name[0] . '_' . $request->name;

        // $user_count = User::where('name', '=', $request->name)
        //     ->where('name', '=', $request->name)->count();
        // //your unique user_name
        // $user_name = $user_name . '_' . $user_count + 1;output//Ali JawishA_Ali Jawish_1

        // 5 way
       // $str = str_replace(" ","",$request->name);//output AliJawish
       //6 way
       //$str = str_replace(" ","",$request->name.uniqid(4));output//AliJawish4625d0f7051c70
       //7 way
       $str =  hash("sha256", $request->name);

        $request->validate([
            'name' => ['required', 'string'],
            'username' => ['nullable', 'alpha_dash', 'unique:acounts'],
            'mobile' => ['required', 'string', 'min:10'],
        ]);

        $user = Acount::create([
            'name' => $request->name,
            'username' => $request->username ? $request->username :  $str,
            'mobile' => $request->mobile,
        ]);
        return $request;
    }
}

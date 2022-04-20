<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search($search)
    {
        $tweet = Tweet::where('body', 'like', '%' . $search . '%')->get();
        $user = User::where('name', 'like', '%' . $search . '%')
            ->orwhere('username', 'like', '%' . $search . '%')->get();
        return response()->json([
            'user' => $user,
            'tweet' => $tweet,

        ]);
    }
}

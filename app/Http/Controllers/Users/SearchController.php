<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Tweet;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');

        $tweet = Tweet::where('body', 'like', '%' . $search . '%')->get();
        $user = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('username', 'like', '%' . $search . '%')->get();
        $hashtag = Hashtag::where('title', 'like', '%' . $search . '%')->get();
        
         if ($type == 'tweet'){
             return $tweet;
         }else if ($type =='user'){
             return $user;
         }else{
             return $hashtag;
         }


        // SELECT users.name , users.username  ,tweets.body
        // FROM users ,tweets
        // where
        // user_id = tweets.user_id

        return response()->json([$type=>[
            'user'    => $user,
            'tweet'   => $tweet,
            'hashtag' => $hashtag
        ]]);
    }
}

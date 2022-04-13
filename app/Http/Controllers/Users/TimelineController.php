<?php

namespace App\Http\Controllers\Users;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tweet\TweetResource;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index(Tweet $tweets, Request $request)
    {
        $tweets = Tweet::whereHas('user.followers', function ($query) {
            $query->where('user_id', Auth::id());
            //->isfollowed();
        })
        ->isLike()
        //->isfollowed()
        ->paginate(10);
        return TweetResource::collection($tweets);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tweet\TweetResource;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::all();
        return TweetResource::collection($tweets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'max:280']
        ]);
       $tweet=  $request->user()->tweets()->create($request->only('body'));
        return new TweetResource($tweet);
    }
}

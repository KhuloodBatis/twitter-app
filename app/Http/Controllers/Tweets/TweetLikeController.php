<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Tweet\TweetResource;

class TweetLikeController extends Controller
{
    public function store(Request $request, Tweet $tweet)
    {
        $tweet->likes()->where('user_id', Auth::id())->exists();
        $tweet->likes()->create([
            'user_id' => $request->user()->id,
        ]);
        return  new TweetResource($tweet);
    }

    public function destroy(Request $request, Tweet $tweet)
    {
        $tweet->likes()->delete([
            'user_id' => $request->user()->id,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tweet\TweetResource;

class TweetLikeController extends Controller
{
    public function store(Tweet $tweet, Request $request)
    {

        if ($tweet->user_id === $request->user()->id)
            return response(null, 401);

        $tweet->likes()->create([
            'user_id' => $request->user()->id,
        ]);


        return  new TweetResource($tweet);
    }

    public function destroy(Tweet $tweet, Request $request)
    {
        if ($tweet->user_id === $request->user()->id) {
            return response(null, 401);
        }
        $tweet->likes()->delete([
            'user_id' => $request->user()->id,
        ]);
    }
}

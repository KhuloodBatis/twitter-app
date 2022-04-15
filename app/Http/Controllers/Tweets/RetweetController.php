<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Tweet\TweetResource;

class RetweetController extends Controller
{
    public function store(Request $request, Tweet $tweet)
    {
        $request->user()->tweets()->create([
            'body' => '',
            'parent_id' => $tweet->id,
        ])->where('user_id', Auth::id())->exists();
        return new TweetResource($tweet);
    }

    public function destroy(Tweet $tweet)
    {
        Tweet::where('id', $tweet->parent_id)->delete();
    }
}

<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Tweets\TweetLiked;
use App\Http\Resources\Tweet\TweetResource;

class TweetLikeController extends Controller
{
    public function store(Request $request, Tweet $tweet)
    {
        $isLiked = $tweet->likes()->where('user_id', Auth::id())->exists();
        if (!$isLiked) {
            $tweet->likes()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        //to prevent the send notification for userself
        if ($request->user()->id !== $tweet->user_id) {
            //to send notification when user do like to nothe user then the firest have notification
            $tweet->user->notify(new TweetLiked($request->user(), $tweet));
        }
        return  new TweetResource($tweet);
    }

    public function destroy(Request $request, Tweet $tweet)
    {
        $tweet->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['status' => 'like was deleted']);
    }
}

<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Tweet\TweetResource;
use App\Notifications\Tweets\TweetRepliedTo;

class RetweetController extends Controller
{
    public function store(Request $request, Tweet $tweet)
    {
        //this code to retweet or quote tweet
        $request->validate([
            'body' => ['nullable', 'string', 'max:280']
        ]);
        $tweet = $request->user()->tweets()->create([
            'body' => $request->body === null ? '' : $request->body,
            'parent_id' => $tweet->id,
        ]);

            //to send notification when user do retweet or quote Tweet to nothe user then the firest have notification
            $tweet->user->notify(new TweetRepliedTo($request->user(), $tweet));

        return new TweetResource($tweet);
    }

    public function destroy(Tweet $tweet)
    {
        $tweet = Tweet::where('id', $tweet->id)->delete();

        return response()->json(['status' => 'retweet was deleted']);
    }
}

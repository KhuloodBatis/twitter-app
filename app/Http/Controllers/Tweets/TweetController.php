<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Like\LikersResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Tweet\TweetResource;

class TweetController extends Controller
{
    public function index(Tweet $tweet)
    {
        $tweets = Tweet::withIsLike()
            ->where('user_id', Auth::id())
            ->paginate(4);
        return TweetResource::collection($tweets);
    }

    public function store(Request $request)
    {
        $request->validate(['body' => ['required', 'max:280']]);
        $tweet =  $request->user()
            ->tweets()
            ->create($request->only('body'));
        return new TweetResource($tweet);
    }

    public function show(Tweet $tweet)
    {
        $tweet->loadIsLiked();
        return new TweetResource($tweet);
    }

    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'body' => ['required', 'max:280']
        ]);
        $tweet->update([
            'body' => $request->body
        ]);
        return new TweetResource($tweet);
    }

    public function destroy(Tweet $tweet)
    {
        Tweet::where('id', $tweet->id)->delete();
    }
}

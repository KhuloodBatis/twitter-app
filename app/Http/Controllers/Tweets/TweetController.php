<?php

namespace App\Http\Controllers\Tweets;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Like\LikersResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Tweet\TweetResource;
use App\Models\Hashtag;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::withIsLike()
            ->where('user_id', Auth::id())
            ->paginate(4);
        return TweetResource::collection($tweets);
    }

    public function store(Request $request)
    {
        $request->validate(['body' => ['required', 'max:280']]);

        $bodySegments = explode(' ', $request->body);
        $hashtagIds = [];

        for ($i = 0; $i < count($bodySegments); $i++) {
            if (str_starts_with($bodySegments[$i], '#')) {
                $hashtag = Hashtag::firstOrCreate([
                    'title' => $bodySegments[$i],
                ]);

                $hashtagIds[] = $hashtag->id;
            }
        }

        $tweet =  $request->user()
            ->tweets()
            ->create($request->only('body'));
        $tweet->hashtags()->attach($hashtagIds);

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

        return response()->json([
            'status' => 'Tweet was deleted',
        ]);
    }
}

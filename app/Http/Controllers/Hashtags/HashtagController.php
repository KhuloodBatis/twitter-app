<?php

namespace App\Http\Controllers\Hashtags;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Hashtag\HashtagResource;

class HashtagController extends Controller
{
    public function index()
    {
        $hashtags = Hashtag::where('user_id', Auth::id())->paginate();
        return HashtagResource::collection($hashtags);
    }


    public function destroy(Hashtag $hashtag)
    {
        Hashtag::where('id', $hashtag->id)->delete();
        return response()->json([
            'status' => 'hashtag was deleted',
        ]);
    }
}

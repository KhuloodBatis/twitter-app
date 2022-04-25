<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Tweet;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Hashtag\HashtagResource;
use App\Http\Resources\Tweet\TweetResource;
use App\Http\Resources\User\UserResource;

class SearchController extends Controller
{
    protected $resourcesMap = [
        'tweet' => TweetResource::class,
        'user' => UserResource::class,
        'hashtag' => HashtagResource::class,
    ];

    public function search(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');

        $result = null;

        if ($type == 'tweet') {
            $result = Tweet::where('body', 'like', '%' . $search . '%')->paginate();
        } else if ($type == 'user') {
            $result = User::where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')->paginate();
        } else {
            $result = Hashtag::where('title', 'like', '%' . $search . '%')->paginate();
        }

        return $this->resourcesMap[$type]::collection($result);
    }
}

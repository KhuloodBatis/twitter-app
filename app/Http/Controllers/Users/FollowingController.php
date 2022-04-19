<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;

class FollowingController extends Controller
{
    public function index(Request $request)
    {
        $followings = $request->user()->followings()
            ->withIsFollowed()
            ->get();
        return UserResource::collection($followings);
    }

    public function store(Request $request, User $user)
    {
        $is_followed = $user->followings()->where('user_id', '!=', Auth::id())->exists();

        if (!$is_followed) {
            $request->user()->followings()->attach($user);
        }

        return response()->json(['status' => 'following was added']);
    }

    public function destroy(Request $request, User $user)
    {
        $request->user()->followings()->detach($user->id);

        return response()->json(['status' => 'following was deleted']);
    }
}

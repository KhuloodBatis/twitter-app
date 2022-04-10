<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

class FollowingController extends Controller
{
    public function index(Request $request)
    {
        $followings = $request->user()->followings()->get();
        return UserResource::collection($followings);
    }

    public function store(User $user, Request $request)
    {
        $request->validate([
            'following_id' => ['required']
        ]);

        $request->user()->followings()->attach(['following_id' => $request->following_id]);
        return response()->json(['status' => 'following was added']);
    }

    public function delete( Request $request,User $user)
    {
     $request->user()->followings()
     ->detach($user->id);
     return response()->json(['status' => 'following was deleted']);
    }
}

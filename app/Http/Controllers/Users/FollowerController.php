<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Follower\FollowerResource;

class FollowerController extends Controller
{
    public function index(Request $request)
    {
        $followers = $request->user()->followers()->isFollowed()->get();
        return UserResource::collection($followers);
    }
}

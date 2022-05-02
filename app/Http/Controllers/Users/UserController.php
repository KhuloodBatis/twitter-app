<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withIsFollowed()
            ->where('id', '!=', Auth::id())
            ->paginate(4);
        return UserResource::collection($users);
    }

    public function who_am_i()
    {
        return Auth::user();
    }
}

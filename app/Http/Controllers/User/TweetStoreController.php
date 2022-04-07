<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TweetStoreController extends Controller
{
    public function store(Request $request)
    {
        $request->user()->tweets()->create($request->only('body'));
        return response()->json($request);
    }
}

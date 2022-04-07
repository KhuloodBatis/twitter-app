<?php

namespace App\Http\Controllers\User;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TweetResource;

class TweetIndexController extends Controller
{
    public function Index(){

       $tweets = Tweet::all();
       return TweetResource::collection($tweets);
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Tweets\TweetController;
use App\Http\Controllers\Users\SearchController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Tweets\RetweetController;
use App\Http\Controllers\Users\FollowerController;
use App\Http\Controllers\Users\TimelineController;
use App\Http\Controllers\Users\FollowingController;
use App\Http\Controllers\Hashtags\HashtagController;
use App\Http\Controllers\Tweets\QuotationController;
use App\Http\Controllers\Tweets\TweetLikeController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Users\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);

Route::prefix('users')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('tweets', [TweetController::class, 'index']);
        Route::post('tweets', [TweetController::class, 'store']);
        Route::get('tweets/{tweet}', [TweetController::class, 'show']);
        Route::put('tweets/{tweet}', [TweetController::class, 'update']);
        Route::delete('tweets/{tweet}', [TweetController::class, 'destroy']);
        Route::post('tweets/{tweet}/likes', [TweetLikeController::class, 'store']);
        Route::delete('tweets/{tweet}/unlikes', [TweetLikeController::class, 'destroy']);
        Route::post('tweets/{tweet}/retweet', [RetweetController::class, 'store']);
        Route::delete('tweets/{tweet}/unretweet', [RetweetController::class, 'destroy']);
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::delete('notifications/{notification}', [NotificationController::class, 'destroy']);


        Route::get('people', [UserController::class, 'index']);
        Route::get('timeline', [TimelineController::class, 'index']);

        Route::get('people/followings', [FollowingController::class, 'index']);
        Route::post('people/{user}/follow', [FollowingController::class, 'store']);
        Route::delete('people/{user}/unfollow', [FollowingController::class, 'destroy']);
        Route::get('people/followers', [FollowerController::class, 'index']);

        Route::get('search', [SearchController::class, 'search']);

        Route::get('hashtags', [HashtagController::class, 'index']);
        Route::delete('hashtags/{hashtag}', [HashtagController::class, 'destroy']);

        Route::get('messages', [MessageController::class, 'index']);
        Route::post('messages', [MessageController::class, 'store']);
        Route::delete('messages/{messge}/delete', [MessageController::class, 'destroy']);
    });
});

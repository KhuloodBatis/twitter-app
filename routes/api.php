<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tweets\TweetLikeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Tweets\TweetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Users\FollowerController;
use App\Http\Controllers\Users\FollowingController;


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
        Route::post('tweets/{tweet}/like', [TweetLikeController::class, 'store']);
        Route::delete('tweets/{tweet}/like', [TweetLikeController::class, 'destroy']);

        Route::get('people', [UserController::class, 'index']);
        Route::get('people/follow', [FollowingController::class, 'index']);
        Route::post('people/{user}/follow', [FollowingController::class, 'store']);
        Route::delete('people/{user}/unfollow', [FollowingController::class, 'destroy']);
        Route::get('people/followers', [FollowerController::class, 'index']);
    });
});

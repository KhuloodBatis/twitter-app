<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\FollowerController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Tweets\TweetController;
use App\Http\Controllers\Auth\RegisterController;
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
        Route::get('people', [UserController::class, 'index']);
        Route::get('people/following', [FollowingController::class, 'index']);
        Route::post('people/following', [FollowingController::class, 'store']);
        Route::delete('people/{user}/unfollowing', [FollowingController::class, 'delete']);
        Route::get('followers', [FollowerController::class, 'index']);
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\TweetController;
use App\Http\Controllers\Auth\RegisterController;


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
    });
});

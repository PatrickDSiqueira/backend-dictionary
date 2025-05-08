<?php

use App\Http\Controllers\UserVisitHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;

Route::post('/auth/signup', [UserAuthController::class, 'register']);

Route::post('/auth/signin', [UserAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('entries/en', [WordController::class, 'index']);

    Route::get('entries/en/{word}', [WordController::class, 'show']);

    Route::post('entries/en/{word}/favorite', [FavoriteController::class, 'store']);

    Route::delete('entries/en/{word}/unfavorite', [FavoriteController::class, 'destroy']);

    Route::get('user/me', [UserController::class, 'show']);

    Route::get('user/me/history', [UserVisitHistoryController::class, 'index']);
});

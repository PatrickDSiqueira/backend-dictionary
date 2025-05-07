<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\WordController;

Route::post('/auth/signup', [UserAuthController::class, 'register']);

Route::post('/auth/signin', [UserAuthController::class, 'login']);

Route::get('entries/en', [WordController::class, 'index']);

Route::get('entries/en/{word}', [WordController::class, 'show']);

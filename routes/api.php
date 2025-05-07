<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;

Route::post('/auth/signup', [UserAuthController::class, 'register']);

Route::post('/auth/signin', [UserAuthController::class, 'login']);

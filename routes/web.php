<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json([
    "message" => "Fullstack Challenge 🏅 - Dictionary"
]));

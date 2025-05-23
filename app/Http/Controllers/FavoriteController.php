<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = $this->favoriteService->getUserFavoriteWords(auth()->user());

        return response()->json($favorites);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->favoriteService->toggleFavorite(true, $request->word, auth()->user());

        return response()->json(['message' => 'Favorite toggled successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->favoriteService->toggleFavorite(false, $request->word, auth()->user());

        return response()->json(['message' => 'Unfavorite toggled successfully']);
    }
}

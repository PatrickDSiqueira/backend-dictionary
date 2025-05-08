<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use App\Services\WordService;
use App\Traits\CacheableResponse;

class WordController extends Controller
{
    use CacheableResponse;

    private WordService $wordService;

    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'sometimes|string|max:255',
            'limit' => 'sometimes|integer|min:1',
        ]);

        $data = $this->processOrCache(
            $request,
            function () use ($request) {
                return $this->wordService->searchWords(
                    $request->input('search', ''),
                    $request->input('limit', 10)
                );
            });

        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($wordLabel)
    {
        $dataWord = $this->wordService->getWordByLabel($wordLabel, auth()->user());

        return response($dataWord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Word $word)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word)
    {
        //
    }
}

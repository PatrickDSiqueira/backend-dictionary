<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use App\Services\WordService;
use App\Traits\CacheableResponse;
use Exception;
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
     * Display the specified resource.
     */
    public function show(Request $request, $wordLabel)
    {
        $dataWord = $this->processOrCache(
            $request,
            function () use ($wordLabel) {
                return $this->wordService->getWordByLabel($wordLabel, auth()->user());
            }
        );

        if (!$dataWord) {

            throw new Exception('Word not found', 404);
        }

        return response($dataWord);
    }
}

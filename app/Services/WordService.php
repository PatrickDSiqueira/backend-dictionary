<?php

namespace App\Services;

use App\Repositories\WordRepository;
use App\Models\User;
use Illuminate\Support\Facades\Http;
class WordService
{
    private WordRepository $wordRepository;
    private UserVisitHistoryService $userVisitHistoryService;

    public function __construct(WordRepository $wordRepository, UserVisitHistoryService $userVisitHistoryService)
    {
        $this->wordRepository = $wordRepository;
        $this->userVisitHistoryService = $userVisitHistoryService;
    }

    public function searchWords(string $search, int $limit): array
    {
        $paginated = $this->wordRepository->getAllWordsPaginated($search, $limit);

        $words = array_map(fn ($word) => $word->label, $paginated->items());

        return [
            'results' => $words,
            'totalDocs' => $paginated->total(),
            'page' => $paginated->currentPage(),
            'totalPages' => $paginated->lastPage(),
            'hasNext' => $paginated->hasMorePages(),
            'hasPrev' => $paginated->currentPage() > 1,
        ];
    }

    public function getWordByLabel(string $label, User $user): array
    {
        $word = $this->wordRepository->getWordsByLabel($label);

        if ($word) {

            $this->userVisitHistoryService->store($user, $word);

            $response = Http::get("https://api.dictionaryapi.dev/api/v2/entries/en/{$label}");
            
            if ($response->successful()) {

                $apiData = $response->json()[0];
                
                $word->meanings = $apiData['meanings'] ?? [];
                $word->phonetics = $apiData['phonetics'] ?? [];
                $word->origin = $apiData['origin'] ?? null;
            }

            return $word->toArray();
        }

        return [];
    }

    public function createWords(array $wordData): void
    {
        $this->wordRepository->createWords($wordData);
    }
}

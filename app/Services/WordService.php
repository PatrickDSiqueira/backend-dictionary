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

    public function getWordByLabel(string $label, User $user): array|false
    {
        $word = $this->wordRepository->getWordsByLabel($label, exactMatch: true);

        if ($word) {

            $wordData = [];

            $this->userVisitHistoryService->store($user, $word);

            $response = Http::get("https://api.dictionaryapi.dev/api/v2/entries/en/{$label}");
            
            if ($response->successful()) {

                $apiData = $response->json()[0];
                
                $wordData['meanings'] = $apiData['meanings'] ?? [];
                $wordData['phonetics'] = $apiData['phonetics'] ?? [];
                $wordData['origin'] = $apiData['origin'] ?? null;
            }

            $wordData['label'] = $word->label;

            return $wordData;
        }

        return false;
    }

    public function createWords(array $wordData): void
    {
        $this->wordRepository->createWords($wordData);
    }
}

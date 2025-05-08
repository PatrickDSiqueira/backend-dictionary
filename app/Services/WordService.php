<?php

namespace App\Services;

use App\Repositories\WordRepository;

class WordService
{
    private WordRepository $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
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

    public function getWordByLabel(string $label): array
    {
        $word = $this->wordRepository->getWordsByLabel($label);

        if ($word) {

            return $word->toArray();
        }

        return [];
    }
}

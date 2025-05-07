<?php

namespace App\Services;

use App\Repositories\WordServiceRepository;

class WordService
{
    private WordServiceRepository $wordServiceRepository;

    public function __construct(WordServiceRepository $wordServiceRepository)
    {
        $this->wordServiceRepository = $wordServiceRepository;
    }

    public function searchWords(string $search, int $limit): array
    {
        $paginated = $this->wordServiceRepository->getAllWordsPaginated($search, $limit);

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
}

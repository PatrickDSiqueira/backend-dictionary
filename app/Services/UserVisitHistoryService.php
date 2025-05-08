<?php

namespace App\Services;

use App\Models\User;
use App\Models\Word;
use App\Repositories\UserVisitHistoryRepository;

class UserVisitHistoryService
{
    private UserVisitHistoryRepository $userVisitHistoryRepository;

    public function __construct(UserVisitHistoryRepository $userVisitHistoryRepository)
    {
        $this->userVisitHistoryRepository = $userVisitHistoryRepository;
    }

    public function getUserHistory(User $user): array
    {
        $paginated = $this->userVisitHistoryRepository->getHistoryPaginated($user);

        $histories = array_map(fn($history) => [
            'word' => $history->word->label,
            'added' => $history->created_at
        ], $paginated->items());

        return [
            'results' => $histories,
            'totalDocs' => $paginated->total(),
            'page' => $paginated->currentPage(),
            'totalPages' => $paginated->lastPage(),
            'hasNext' => $paginated->hasMorePages(),
            'hasPrev' => $paginated->currentPage() > 1,
        ];
    }

    public function store(User $user, Word $word): void
    {
        $this->userVisitHistoryRepository->create($user, $word);
    }
}

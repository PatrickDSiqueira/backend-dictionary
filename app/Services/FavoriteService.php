<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;
use App\Models\User;
use App\Repositories\WordRepository;

class FavoriteService
{
    protected FavoriteRepository $favoriteRepository;
    protected WordRepository $wordRepository;

    public function __construct(FavoriteRepository $favoriteRepository, WordRepository $wordRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
        $this->wordRepository = $wordRepository;
    }

    public function getUserFavoriteWords(User $user): array
    {
        $paginated = $this->favoriteRepository->getFavoriteWordsPaginated($user);

        $favorites = array_map(fn($favorite) => [
            'word' => $favorite->word->label,
            'added' => $favorite->created_at
        ], $paginated->items());

        return [
            'results' => $favorites,
            'totalDocs' => $paginated->total(),
            'page' => $paginated->currentPage(),
            'totalPages' => $paginated->lastPage(),
            'hasNext' => $paginated->hasMorePages(),
            'hasPrev' => $paginated->currentPage() > 1,
        ];
    }

    public function toggleFavorite(bool $isFavorite, string $wordLabel, User $user): void
    {
        $word = $this->wordRepository->getWordsByLabel($wordLabel);

        if ($isFavorite) {

            $this->favoriteRepository->favoriteWord($word, $user);

        } else {

            $this->favoriteRepository->unfavoriteWord($word, $user);
        }
    }
}


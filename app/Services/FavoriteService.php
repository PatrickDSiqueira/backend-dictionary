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


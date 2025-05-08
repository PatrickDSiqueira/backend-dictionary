<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;
use App\Models\User;

class FavoriteService
{
    protected FavoriteRepository $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function toggleFavorite(bool $isFavorite, string $word, User $user): void
    {
        if ($isFavorite) {

            $this->favoriteRepository->unfavoriteWord($word, $user);

        } else {

            $this->favoriteRepository->favoriteWord($word, $user);
        }
    }
}


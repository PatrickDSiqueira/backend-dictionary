<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\User;

class FavoriteRepository
{
    public function favoriteWord(string $word, User $user)
    {
        Favorite::create([
            'word' => $word,
            'user_id' => $user->id,
        ]);
    }

    public function unfavoriteWord(string $word, User $user)
    {
        Favorite::where('word', $word)
            ->where('user_id', $user->id)
            ->delete();
    }
}

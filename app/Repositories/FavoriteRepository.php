<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Word;

class FavoriteRepository
{
    public function favoriteWord(Word $word, User $user)
    {
        Favorite::query()->firstOrCreate([
            'word_id' => $word->id,
            'user_id' => $user->id,
        ]);
    }

    public function unfavoriteWord(Word $word, User $user)
    {
        Favorite::where('word_id', $word->id)
            ->where('user_id', $user->id)
            ->delete();
    }
}

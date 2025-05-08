<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Word;

class FavoriteRepository
{

    public function getFavoriteWordsPaginated(User $user)
    {
        return $this->builderFavoriteWords($user)
            ->paginate(10);
    }

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

    public function builderFavoriteWords(User $user)
    {
        return Favorite::query()->where('user_id', $user->id);
    }
}

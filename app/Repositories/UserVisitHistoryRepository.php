<?php

namespace App\Repositories;

use App\Models\UserVisitHistory;
use App\Models\User;
use App\Models\Word;

class UserVisitHistoryRepository
{
    public function getHistoryPaginated(User $user)
    {
        return $this->builderHistory($user)->paginate(10);
    }

    public function builderHistory(User $user)
    {
        return UserVisitHistory::query()->where('user_id', $user->id);
    }

    public function create(User $user, Word $word)
    {
        return UserVisitHistory::query()
            ->create([
                'user_id' => $user->id,
                'word_id' => $word->id,
            ]);
    }
}

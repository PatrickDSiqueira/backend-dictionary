<?php

namespace App\Repositories;

use App\Models\Word;

use \Illuminate\Pagination\LengthAwarePaginator;

class WordServiceRepository
{

    public function getAllWordsPaginated(string $search, int $perPage, array $columns = ['label']): LengthAwarePaginator
    {
        $query = $this->getWordsByLabel($search, $columns);

        return $query->paginate($perPage);
    }

    public function getWordsByLabel(string $label, array $columns)
    {
        return Word::query()
            ->where('label', 'like', "%$label%")
            ->select($columns);
    }
}

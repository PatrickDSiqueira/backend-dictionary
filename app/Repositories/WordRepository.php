<?php

namespace App\Repositories;

use App\Models\Word;

use \Illuminate\Pagination\LengthAwarePaginator;

class WordRepository
{

    public function getAllWordsPaginated(string $search, int $perPage, array $columns = ['label']): LengthAwarePaginator
    {
        $query = $this->builderWordsByLabel($search, $columns);

        return $query->paginate($perPage);
    }

    public function builderWordsByLabel(string $label, array $columns = ['*'])
    {
        return Word::query()
            ->where('label', 'like', "%$label%")
            ->select($columns);
    }

    public function getWordsByLabel(string $label, array $columns = ['*'])
    {
        return $this->builderWordsByLabel($label, $columns)
            ->first();
    }

    public function createWords(array $wordData): void
    {
        Word::query()->insert($wordData);
    }
}

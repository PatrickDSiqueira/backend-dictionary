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

    public function builderWordsByLabel(string $label, array $columns = ['*'], bool $exactMatch = false)
    {
        $query = Word::query();

        if ($exactMatch) {

            $query->where('label', $label);

        } else {

            $query->where('label', 'like', "%$label%");
        }

        return $query->select($columns);
    }

    public function getWordsByLabel(string $label, array $columns = ['*'], bool $exactMatch = false)
    {
        return $this->builderWordsByLabel($label, $columns, $exactMatch)
            ->first();
    }

    public function createWords(array $wordData): void
    {
        Word::query()->insert($wordData);
    }
}

<?php

namespace App\Repositories;

use App\Models\User;

class UserAuthServiceRepository
{
    public function createUser(array $data)
    {
        return User::query()->create($data);
    }
}

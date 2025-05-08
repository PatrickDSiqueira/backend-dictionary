<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUser(User $user): array
    {
        return $user->only(['id', 'name', 'email']);
    }
}

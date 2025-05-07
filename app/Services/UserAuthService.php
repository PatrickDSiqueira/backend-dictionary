<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserAuthServiceRepository;

class UserAuthService
{
    private UserAuthServiceRepository $userAuthServiceRepository;

    public function __construct(UserAuthServiceRepository $userAuthServiceRepository)
    {
        $this->userAuthServiceRepository = $userAuthServiceRepository;
    }

    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        $user = $this->userAuthServiceRepository->createUser($data);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'token' => $this->generateToken($user)
        ];
    }

    private function generateToken(User $user)
    {
        return $user->createToken('API Token')->accessToken;
    }
}

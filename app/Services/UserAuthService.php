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

        $token = $this->generateToken($user);

        return $this->returnAuthData($user, $token);
    }

    private function generateToken(User $user): string
    {
        return $user->createToken('API Token')->accessToken;
    }

    private function returnAuthData(User $user, string $token): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'token' => $token
        ];
    }

    public function login(array $data)
    {

        if (!auth()->attempt($data)) {

            return response(['error_message' => 'Incorrect Details. Please try again']);
        }

        $user = auth()->user();

        $token = $this->generateToken($user);

        return $this->returnAuthData($user, $token);
    }
}

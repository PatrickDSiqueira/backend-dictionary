<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserAuthService;
class UserAuthController extends Controller
{
    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',

        ]);

        $data = $this->userAuthService->register($data);

        return response($data);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required|exists:users,email',
            'password' => 'required'
        ]);

        $data = $this->userAuthService->login($data);

        return response($data);

    }
}



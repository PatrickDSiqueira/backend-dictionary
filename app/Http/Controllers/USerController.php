<?php

namespace App\Http\Controllers;

use App\Services\UserService;
class USerController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userData = $this->userService->getUser(auth()->user());

        return response()->json($userData);
    }
}

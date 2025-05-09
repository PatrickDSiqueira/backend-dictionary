<?php

namespace App\Http\Controllers;

use App\Services\UserVisitHistoryService;

class UserVisitHistoryController extends Controller
{
    private UserVisitHistoryService $userVisitHistoryService;

    public function __construct(UserVisitHistoryService $userVisitHistoryService)
    {
        $this->userVisitHistoryService = $userVisitHistoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = $this->userVisitHistoryService->getUserHistory(auth()->user());

        return response()->json($history);
    }

}

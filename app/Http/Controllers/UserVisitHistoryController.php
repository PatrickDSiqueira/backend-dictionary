<?php

namespace App\Http\Controllers;

use App\Models\UserVisitHistory;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserVisitHistory $userVisitHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserVisitHistory $userVisitHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserVisitHistory $userVisitHistory)
    {
        //
    }
}

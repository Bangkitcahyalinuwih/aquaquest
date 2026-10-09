<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $pemain = User::where('role', 'user')
            ->orderByDesc('total_xp')
            ->take(20)
            ->get(['id', 'name', 'total_xp', 'level']);

        return view('leaderboard.index', compact('pemain'));
    }
}
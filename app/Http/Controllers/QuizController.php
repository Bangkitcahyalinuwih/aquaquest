<?php

namespace App\Http\Controllers;

use App\Models\GameHistory;
use App\Services\KuisService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return view('kuis.index');
    }

    public function mulai(Request $request, KuisService $kuisService)
    {
        $game = $kuisService->mulai($request->user());

        return response()->json([
            'game_id' => $game->id,
            'deadline_at' => $game->deadline_at->toIso8601String(),
            'soal' => $kuisService->soalUntukSesi($game),
        ]);
    }

    public function jawab(Request $request, GameHistory $game, KuisService $kuisService)
    {
        if ($game->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'soal_id' => 'required|integer',
            'pilihan' => 'required|in:a,b,c,d',
        ]);

        return response()->json($kuisService->jawab($game, $data['soal_id'], $data['pilihan']));
    }

    public function selesai(Request $request, GameHistory $game, KuisService $kuisService)
    {
        if ($game->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json($kuisService->selesai($game));
    }
}

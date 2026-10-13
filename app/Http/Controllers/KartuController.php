<?php

namespace App\Http\Controllers;

use App\Models\Kartu;
use Illuminate\Http\Request;

class KartuController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('kartu.index', [
            'kartu' => Kartu::with('biota:id,nama')->orderBy('xp_syarat')->get(),
            'dimiliki' => $user->koleksiKartu()->pluck('kartu_id')->all(),
            'totalXp' => $user->total_xp,
        ]);
    }
}

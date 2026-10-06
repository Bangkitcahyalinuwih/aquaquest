<?php

namespace App\Http\Controllers;

use App\Models\Kartu;

class KartuController extends Controller
{
    public function index()
    {
        $kartu = Kartu::with('biota')->get();
        $totalXp = auth()->user()->total_xp;

        return view('kartu.index', compact('kartu', 'totalXp'));
    }
}
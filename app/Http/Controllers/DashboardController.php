<?php

namespace App\Http\Controllers;

use App\Models\Kartu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $kartuBerikutnya = Kartu::where('xp_syarat', '>', $user->total_xp)
            ->orderBy('xp_syarat')
            ->first();

        $jumlahKartuDimiliki = $user->koleksiKartu()->count();

        return view('dashboard', compact('user', 'kartuBerikutnya', 'jumlahKartuDimiliki'));
    }
}
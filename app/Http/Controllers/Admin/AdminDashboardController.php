<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biota;
use App\Models\GameHistory;
use App\Models\Kartu;
use App\Models\KontenEdukasi;
use App\Models\SoalKuis;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jumlahBiota' => Biota::count(),
            'jumlahEdukasi' => KontenEdukasi::count(),
            'jumlahSoal' => SoalKuis::count(),
            'jumlahKartu' => Kartu::count(),
            'jumlahPemain' => User::where('role', 'user')->count(),
            'sesiSelesai' => GameHistory::where('status', 'selesai')->count(),
            'pemainTeratas' => User::where('role', 'user')->orderByDesc('total_xp')->take(5)->get(['id', 'name', 'total_xp', 'level']),
            'sesiTerbaru' => GameHistory::with('user:id,name')->where('status', 'selesai')->latest('selesai_at')->take(5)->get(),
        ]);
    }
}

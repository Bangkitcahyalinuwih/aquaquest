<?php

namespace App\Http\Controllers;

use App\Models\Kartu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $kartuBerikutnya = Kartu::where('xp_syarat', '>', $user->total_xp)
            ->orderBy('xp_syarat')
            ->first();

        $jumlahKartuDimiliki = $user->koleksiKartu()->count();

        $sesiSelesai = $user->gameHistory()->where('status', 'selesai');
        $pernahMain = (clone $sesiSelesai)->exists();
        $sudahMainHariIni = (clone $sesiSelesai)->whereDate('selesai_at', today())->exists();

        return view('dashboard', compact(
            'user',
            'kartuBerikutnya',
            'jumlahKartuDimiliki',
            'pernahMain',
            'sudahMainHariIni'
        ));
    }
}

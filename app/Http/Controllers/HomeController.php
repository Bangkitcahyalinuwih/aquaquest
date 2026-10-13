<?php

namespace App\Http\Controllers;

use App\Models\Biota;
use App\Models\KontenEdukasi;
use App\Models\SoalKuis;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'biotaPilihan' => Biota::inRandomOrder()->take(3)->get(),
            'edukasiTerbaru' => KontenEdukasi::latest()->take(3)->get(),
            'jumlahBiota' => Biota::count(),
            'jumlahSoal' => SoalKuis::count(),
            'jumlahPemain' => User::where('role', 'user')->count(),
        ]);
    }
}

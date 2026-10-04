<?php

namespace App\Http\Controllers;

use App\Models\Biota;

class BiotaController extends Controller
{
    // Dipanggil saat orang buka GET /biota
    public function index()
    {
        $biota = Biota::latest()->paginate(10);
        // latest()  -> urutkan dari yang terbaru dibuat
        // paginate(10) -> ambil 10 per halaman, otomatis sediakan link "halaman 2, 3, dst."

        return view('biota.index', compact('biota'));
        // artinya: tampilkan file resources/views/biota/index.blade.php,
        // kirim variabel $biota ke file itu
    }

    // Dipanggil saat orang buka GET /biota/{slug}, misal /biota/penyu-hijau
    public function show(Biota $biota)
    {
        // Laravel OTOMATIS mencari baris biota dengan slug yang cocok dari URL,
        // berkat getRouteKeyName() yang kamu tulis di model tadi.
        // Kalau tidak ketemu, otomatis muncul halaman 404 — kamu tidak perlu cek manual.

        return view('biota.show', compact('biota'));
    }
}
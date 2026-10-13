<?php

namespace App\Http\Controllers;

use App\Models\Biota;
use Illuminate\Http\Request;

class BiotaController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:100',
        ]);

        $biota = Biota::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $kata = '%'.$request->q.'%';
                $query->where(fn ($w) => $w->where('nama', 'like', $kata)->orWhere('nama_latin', 'like', $kata));
            })
            ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->kategori))
            ->orderBy('nama')
            ->paginate(9)
            ->withQueryString();

        $daftarKategori = Biota::query()->distinct()->orderBy('kategori')->pluck('kategori');

        return view('biota.index', compact('biota', 'daftarKategori'));
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

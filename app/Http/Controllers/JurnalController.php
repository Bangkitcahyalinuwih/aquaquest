<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    // 1. READ: Menampilkan daftar seluruh jurnal ke halaman tabel
    public function index()
    {
        // Mengambil data jurnal beserta data user pembuatnya, diurutkan dari yang terbaru
        $jurnals = Jurnal::with('user')->latest()->get();
        
        // Melempar data $jurnals ke file resources/views/jurnal/index.blade.php
        return view('jurnal.index', compact('jurnals'));
    }

    // 2. CREATE (Form): Menampilkan halaman formulir tambah jurnal
    public function create()
    {
        return view('jurnal.create');
    }

    // 3. CREATE (Proses): Validasi dan simpan data dari form ke database
    public function store(Request $request)
    {
        // Syarat 4 UTS: Server-side Validation
        $validated = $request->validate([
            'nama_biota' => 'required|string|max:255',
            'lokasi'     => 'required|string|max:255',
            'kondisi'    => 'required|in:sehat,terluka,langka,punah',
            'catatan'    => 'required|string|min:10',
            'jenis'      => 'required|in:ikan,terumbu_karang,moluska'
        ]);

        // Menyisipkan ID user yang sedang login ke dalam data yang akan disimpan
        $validated['user_id'] = Auth::id();

        // Simpan ke tabel jurnals
        Jurnal::create($validated);

        // Arahkan kembali ke halaman tabel dengan pesan sukses
        return redirect()->route('jurnal.index')
            ->with('success', 'Catatan jurnal penyelam berhasil ditambahkan!');
    }

    // 4. UPDATE (Form): Menampilkan form edit dengan data lama
    public function edit(Jurnal $jurnal)
    {
        return view('jurnal.edit', compact('jurnal'));
    }

    // 5. UPDATE (Proses): Validasi dan perbarui data di database
    public function update(Request $request, Jurnal $jurnal)
    {
        $validated = $request->validate([
            'nama_biota' => 'required|string|max:255',
            'lokasi'     => 'required|string|max:255',
            'kondisi'    => 'required|in:sehat,terluka,langka,punah',
            'catatan'    => 'required|string|min:10',
            'jenis'      => 'required|in:ikan,terumbu_karang,moluska'
        ]);

        $jurnal->update($validated);

        return redirect()->route('jurnal.index')
            ->with('success', 'Catatan jurnal berhasil diperbarui!');
    }

    // 6. DELETE: Menghapus data jurnal dari database
    public function destroy(Jurnal $jurnal)
    {
        $jurnal->delete();

        return redirect()->route('jurnal.index')
            ->with('success', 'Catatan jurnal berhasil dihapus!');
    }
}
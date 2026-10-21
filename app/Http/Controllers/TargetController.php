<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Biota;
use App\Models\KontenEdukasi;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::where('user_id', auth()->id())->latest()->get();
        return view('targets.index', compact('targets'));
    }

    public function create()
    {
        $biotas = class_exists(Biota::class) ? Biota::all() : collect();
        $edukasis = class_exists(KontenEdukasi::class) ? KontenEdukasi::all() : collect();

        return view('targets.create', compact('biotas', 'edukasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:Kuis,Ensiklopedia,Materi Edukasi',
        ]);

        $userId = auth()->id();
        $kategori = $request->kategori;
        $judulTarget = '';
        $refId = null;

        if ($kategori === 'Kuis') {
            $judulTarget = 'Menyelesaikan Kuis Interaktif';
        } elseif ($kategori === 'Ensiklopedia') {
            $request->validate(['biota_id' => 'required']);
            $biota = Biota::findOrFail($request->biota_id);
            $namaBiota = $biota->nama ?? $biota->nama_biota ?? 'Biota Laut';
            $judulTarget = 'Membaca Ensiklopedia: ' . $namaBiota;
            $refId = $biota->id;
        } elseif ($kategori === 'Materi Edukasi') {
            $request->validate(['edukasi_id' => 'required']);
            $edukasi = KontenEdukasi::findOrFail($request->edukasi_id);
            $judulMateri = $edukasi->judul ?? $edukasi->judul_materi ?? 'Materi Edukasi';
            $judulTarget = 'Mempelajari Materi: ' . $judulMateri;
            $refId = $edukasi->id;
        }

        // Cek jika target ini sudah pernah SELESAI
        $sudahSelesai = Target::where('user_id', $userId)
            ->where('judul_target', $judulTarget)
            ->where('status', 'Selesai')
            ->exists();

        if ($sudahSelesai) {
            return back()->withErrors([
                'kategori' => 'Target ini sudah pernah kamu selesaikan! Hapus target lama jika ingin membuatnya lagi.'
            ])->withInput();
        }

        Target::create([
            'user_id' => $userId,
            'judul_target' => $judulTarget,
            'kategori' => $kategori,
            'ref_id' => $refId,
            'status' => 'Belum Selesai',
        ]);

        return redirect()->route('targets.index')->with('success', 'Target belajar berhasil ditambahkan!');
    }

    public function edit(Target $target)
    {
        return view('targets.edit', compact('target'));
    }

    public function update(Request $request, Target $target)
    {
        $request->validate([
            'status' => 'required|in:Belum Selesai,Selesai',
        ]);

        $target->update([
            'status' => $request->status,
        ]);

        return redirect()->route('targets.index')->with('success', 'Status target berhasil diperbarui!');
    }

    public function destroy(Target $target)
    {
        $target->delete();
        return redirect()->route('targets.index')->with('success', 'Target berhasil dihapus!');
    }
}
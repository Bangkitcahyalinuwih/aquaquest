<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biota;
use App\Models\KontenEdukasi;
use App\Services\GambarService;
use App\Services\SlugService;
use Illuminate\Http\Request;

class KontenEdukasiAdminController extends Controller
{
    public function index()
    {
        $konten = KontenEdukasi::with('biota:id,nama')->latest()->paginate(10);

        return view('admin.edukasi.index', compact('konten'));
    }

    public function create()
    {
        return view('admin.edukasi.create', ['daftarBiota' => $this->daftarBiota()]);
    }

    public function store(Request $request, GambarService $gambar, SlugService $slug)
    {
        $data = $request->validate($this->aturan());
        unset($data['gambar']);

        $data['slug'] = $slug->unik(KontenEdukasi::class, $data['judul']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'edukasi');
        }

        KontenEdukasi::create($data);

        return redirect()->route('admin.edukasi.index')->with('status', 'Konten edukasi berhasil ditambahkan.');
    }

    public function edit(KontenEdukasi $konten)
    {
        return view('admin.edukasi.edit', [
            'konten' => $konten,
            'daftarBiota' => $this->daftarBiota(),
        ]);
    }

    public function update(Request $request, KontenEdukasi $konten, GambarService $gambar)
    {
        $data = $request->validate($this->aturan());
        unset($data['gambar']);

        if ($request->hasFile('gambar')) {
            $gambar->hapus($konten->gambar);
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'edukasi');
        }

        $konten->update($data);

        return redirect()->route('admin.edukasi.index')->with('status', 'Konten edukasi berhasil diperbarui.');
    }

    public function destroy(KontenEdukasi $konten, GambarService $gambar)
    {
        $gambar->hapus($konten->gambar);
        $konten->delete();

        return redirect()->route('admin.edukasi.index')->with('status', 'Konten edukasi berhasil dihapus.');
    }

    private function daftarBiota()
    {
        return Biota::orderBy('nama')->get(['id', 'nama']);
    }

    private function aturan(): array
    {
        return [
            'biota_id' => 'nullable|exists:biota,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}

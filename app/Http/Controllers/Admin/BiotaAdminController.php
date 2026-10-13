<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biota;
use App\Services\GambarService;
use App\Services\SlugService;
use Illuminate\Http\Request;

class BiotaAdminController extends Controller
{
    public function index()
    {
        $biota = Biota::orderBy('nama')->paginate(10);

        return view('admin.biota.index', compact('biota'));
    }

    public function create()
    {
        return view('admin.biota.create');
    }

    public function store(Request $request, GambarService $gambar, SlugService $slug)
    {
        $data = $request->validate($this->aturan());
        unset($data['gambar']);

        $data['slug'] = $slug->unik(Biota::class, $data['nama']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'biota');
        }

        Biota::create($data);

        return redirect()->route('admin.biota.index')->with('status', 'Biota berhasil ditambahkan.');
    }

    public function edit(Biota $biota)
    {
        return view('admin.biota.edit', compact('biota'));
    }

    public function update(Request $request, Biota $biota, GambarService $gambar)
    {
        $data = $request->validate($this->aturan());
        unset($data['gambar']);

        if ($request->hasFile('gambar')) {
            $gambar->hapus($biota->gambar);
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'biota');
        }

        // Slug sengaja tidak diubah saat edit supaya tautan lama tetap berlaku.
        $biota->update($data);

        return redirect()->route('admin.biota.index')->with('status', 'Biota berhasil diperbarui.');
    }

    public function destroy(Biota $biota, GambarService $gambar)
    {
        $gambar->hapus($biota->gambar);
        $biota->delete();

        return redirect()->route('admin.biota.index')->with('status', 'Biota berhasil dihapus.');
    }

    private function aturan(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'nama_latin' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'habitat' => 'nullable|string|max:255',
            'status_konservasi' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}

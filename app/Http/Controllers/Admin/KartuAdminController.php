<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biota;
use App\Models\Kartu;
use App\Services\GambarService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KartuAdminController extends Controller
{
    public function index()
    {
        $kartu = Kartu::with('biota:id,nama')->orderBy('xp_syarat')->paginate(10);

        return view('admin.kartu.index', compact('kartu'));
    }

    public function create()
    {
        // Satu biota hanya boleh punya satu kartu: tampilkan biota yang belum punya kartu.
        $daftarBiota = Biota::doesntHave('kartu')->orderBy('nama')->get(['id', 'nama']);

        return view('admin.kartu.create', compact('daftarBiota'));
    }

    public function store(Request $request, GambarService $gambar)
    {
        $data = $request->validate([
            'biota_id' => 'required|exists:biota,id|unique:kartu,biota_id',
            'nama' => 'required|string|max:255',
            'xp_syarat' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['gambar'] = $gambar->simpan($request->file('gambar'), 'kartu');

        Kartu::create($data);

        return redirect()->route('admin.kartu.index')->with('status', 'Kartu berhasil ditambahkan.');
    }

    public function edit(Kartu $kartu)
    {
        $daftarBiota = Biota::where(fn ($q) => $q->doesntHave('kartu')->orWhere('id', $kartu->biota_id))
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return view('admin.kartu.edit', compact('kartu', 'daftarBiota'));
    }

    public function update(Request $request, Kartu $kartu, GambarService $gambar)
    {
        $data = $request->validate([
            'biota_id' => ['required', 'exists:biota,id', Rule::unique('kartu', 'biota_id')->ignore($kartu->id)],
            'nama' => 'required|string|max:255',
            'xp_syarat' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        unset($data['gambar']);

        if ($request->hasFile('gambar')) {
            $gambar->hapus($kartu->gambar);
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'kartu');
        }

        $kartu->update($data);

        return redirect()->route('admin.kartu.index')->with('status', 'Kartu berhasil diperbarui.');
    }

    public function destroy(Kartu $kartu, GambarService $gambar)
    {
        $gambar->hapus($kartu->gambar);
        $kartu->delete();

        return redirect()->route('admin.kartu.index')->with('status', 'Kartu berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biota;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BiotaAdminController extends Controller
{
    public function index()
    {
        $biota = Biota::latest()->paginate(10);

        return view('admin.biota.index', compact('biota'));
    }

    public function create()
    {
        return view('admin.biota.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_latin' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'habitat' => 'nullable|string|max:255',
            'status_konservasi' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data['slug'] = Str::slug($data['nama']);

        Biota::create($data);

        return redirect()->route('admin.biota.index')->with('status', 'Biota berhasil ditambahkan.');
    }

    public function edit(Biota $biota)
    {
        return view('admin.biota.edit', compact('biota'));
    }

    public function update(Request $request, Biota $biota)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_latin' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'habitat' => 'nullable|string|max:255',
            'status_konservasi' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $biota->update($data);

        return redirect()->route('admin.biota.index')->with('status', 'Biota berhasil diperbarui.');
    }

    public function destroy(Biota $biota)
    {
        $biota->delete();

        return redirect()->route('admin.biota.index')->with('status', 'Biota berhasil dihapus.');
    }
}

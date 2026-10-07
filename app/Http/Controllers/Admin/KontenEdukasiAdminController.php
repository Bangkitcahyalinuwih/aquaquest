<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontenEdukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KontenEdukasiAdminController extends Controller
{
    public function index()
    {
        $konten = KontenEdukasi::latest()->paginate(10);

        return view('admin.edukasi.index', compact('konten'));
    }

    public function create()
    {
        return view('admin.edukasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'biota_id' => 'nullable|exists:biota,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $data['slug'] = Str::slug($data['judul']);

        KontenEdukasi::create($data);

        return redirect()->route('admin.edukasi.index')->with('status', 'Konten edukasi berhasil ditambahkan.');
    }

    public function edit(KontenEdukasi $edukasi)
    {
        return view('admin.edukasi.edit', ['konten' => $edukasi]);
    }

    public function update(Request $request, KontenEdukasi $edukasi)
    {
        $data = $request->validate([
            'biota_id' => 'nullable|exists:biota,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $edukasi->update($data);

        return redirect()->route('admin.edukasi.index')->with('status', 'Konten edukasi berhasil diperbarui.');
    }

    public function destroy(KontenEdukasi $edukasi)
    {
        $edukasi->delete();

        return redirect()->route('admin.edukasi.index')->with('status', 'Konten edukasi berhasil dihapus.');
    }
}
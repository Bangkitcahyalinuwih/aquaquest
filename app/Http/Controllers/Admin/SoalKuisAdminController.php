<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biota;
use App\Models\SoalKuis;
use App\Services\GambarService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SoalKuisAdminController extends Controller
{
    public function index()
    {
        $soal = SoalKuis::with('biota:id,nama')->latest()->paginate(10);

        return view('admin.soal.index', compact('soal'));
    }

    public function create()
    {
        return view('admin.soal.create', ['daftarBiota' => $this->daftarBiota()]);
    }

    public function store(Request $request, GambarService $gambar)
    {
        $data = $request->validate($this->aturan($request));
        unset($data['gambar']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'soal');
        }

        SoalKuis::create($data);

        return redirect()->route('admin.soal.index')->with('status', 'Soal berhasil ditambahkan.');
    }

    public function edit(SoalKuis $soal)
    {
        return view('admin.soal.edit', ['soal' => $soal, 'daftarBiota' => $this->daftarBiota()]);
    }

    public function update(Request $request, SoalKuis $soal, GambarService $gambar)
    {
        $data = $request->validate($this->aturan($request, $soal));
        unset($data['gambar']);

        if ($request->hasFile('gambar')) {
            $gambar->hapus($soal->gambar);
            $data['gambar'] = $gambar->simpan($request->file('gambar'), 'soal');
        }

        $soal->update($data);

        return redirect()->route('admin.soal.index')->with('status', 'Soal berhasil diperbarui.');
    }

    public function destroy(SoalKuis $soal, GambarService $gambar)
    {
        $gambar->hapus($soal->gambar);
        $soal->delete();

        return redirect()->route('admin.soal.index')->with('status', 'Soal berhasil dihapus.');
    }

    private function daftarBiota()
    {
        return Biota::orderBy('nama')->get(['id', 'nama']);
    }

    private function aturan(Request $request, ?SoalKuis $soal = null): array
    {
        // Soal bertipe "gambar" wajib punya gambar (saat membuat, atau saat edit jika belum ada).
        $wajibGambar = $request->input('tipe') === 'gambar' && (! $soal || ! $soal->gambar);

        return [
            'biota_id' => 'nullable|exists:biota,id',
            'tipe' => ['required', Rule::in(['teks', 'gambar'])],
            'pertanyaan' => 'required|string',
            'gambar' => [Rule::requiredIf($wajibGambar), 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'opsi_a' => 'required|string|max:255',
            'opsi_b' => 'required|string|max:255',
            'opsi_c' => 'required|string|max:255',
            'opsi_d' => 'required|string|max:255',
            'jawaban_benar' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
            'poin' => 'required|integer|min:1|max:100',
        ];
    }
}

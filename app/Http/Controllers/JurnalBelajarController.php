<?php

namespace App\Http\Controllers;

use App\Models\JurnalBelajar;
use App\Models\KontenEdukasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurnalBelajarController extends Controller
{
    // READ: Menampilkan daftar jurnal milik user yang sedang login beserta statistik ringkasannya
    public function index(Request $request)
    {
        $user = $request->user();

        // Mengambil jurnal milik user, menggunakan Eager Loading with() untuk mencegah masalah N+1 Query
        $jurnal = $user->jurnalBelajar()
            ->with('kontenEdukasi:id,judul')
            ->latest()
            ->paginate(10);

        // Menghitung ringkasan data menggunakan fungsi agregat SQL (COUNT dan AVG)
        $statistik = [
            'total' => $user->jurnalBelajar()->count(),
            'selesai' => $user->jurnalBelajar()->where('status', 'selesai')->count(),
            'rataRating' => $user->jurnalBelajar()->whereNotNull('rating')->avg('rating'),
        ];

        return view('jurnal.index', compact('jurnal', 'statistik'));
    }

    // CREATE (Form): Menampilkan form tambah jurnal
    public function create(Request $request)
    {
        // Ambil array ID artikel yang SUDAH pernah dijurnalkan oleh user ini
        $sudahDijurnalkan = $request->user()->jurnalBelajar()->pluck('konten_edukasi_id');

        // whereNotIn: Hanya tampilkan artikel yang BELUM pernah dijurnalkan di dropdown form
        $daftarArtikel = KontenEdukasi::whereNotIn('id', $sudahDijurnalkan)
            ->orderBy('judul')
            ->get(['id', 'judul']);

        return view('jurnal.create', compact('daftarArtikel'));
    }

    // CREATE (Simpan): Memvalidasi dan menyimpan jurnal baru ke database
    public function store(Request $request)
    {
        $data = $request->validate([
            'konten_edukasi_id' => [
                'required',
                'exists:konten_edukasi,id',
                // Validasi unique komposit: satu user tidak boleh menjurnalkan artikel yang sama dua kali
                Rule::unique('jurnal_belajar', 'konten_edukasi_id')
                    ->where('user_id', $request->user()->id),
            ],
        ] + $this->aturanIsi());

        // Disimpan lewat relasi agar user_id otomatis terisi ID user yang sedang login
        $request->user()->jurnalBelajar()->create($this->rapikan($data));

        return redirect()->route('jurnal.index')->with('status', 'Jurnal berhasil disimpan.');
    }

    // UPDATE (Form): Menampilkan form edit jurnal
    public function edit(Request $request, JurnalBelajar $jurnal)
    {
        $this->pastikanPemilik($request, $jurnal); // Proteksi IDOR

        $jurnal->load('kontenEdukasi:id,judul');

        return view('jurnal.edit', compact('jurnal'));
    }

    // UPDATE (Simpan): Memvalidasi dan memperbarui data jurnal
    public function update(Request $request, JurnalBelajar $jurnal)
    {
        $this->pastikanPemilik($request, $jurnal); // Proteksi IDOR

        $data = $request->validate($this->aturanIsi());

        $jurnal->update($this->rapikan($data));

        return redirect()->route('jurnal.index')->with('status', 'Jurnal berhasil diperbarui.');
    }

    // DELETE: Menghapus jurnal
    public function destroy(Request $request, JurnalBelajar $jurnal)
    {
        $this->pastikanPemilik($request, $jurnal); // Proteksi IDOR

        $jurnal->delete();

        return redirect()->route('jurnal.index')->with('status', 'Jurnal berhasil dihapus.');
    }

    // Fungsi Keamanan (Otorisasi): Mencegah User A mengedit/menghapus jurnal milik User B
    private function pastikanPemilik(Request $request, JurnalBelajar $jurnal): void
    {
        abort_if($jurnal->user_id !== $request->user()->id, 403);
    }

    // Aturan validasi (Prinsip DRY: dipakai bersama oleh store dan update)
    private function aturanIsi(): array
    {
        return [
            'ringkasan' => 'required|string|min:20|max:1000',
            'status' => ['required', Rule::in(['sedang_dibaca', 'selesai'])],
            // required_if:status,selesai -> Rating wajib diisi jika status selesai, boleh kosong jika sedang dibaca
            'rating' => ['required_if:status,selesai', 'nullable', 'integer', 'between:1,5'],
            'target_selesai' => 'nullable|date', // Validasi tipe data tanggal untuk target membaca
        ];
    }

    // Pembersihan data bisnis sebelum masuk database
    private function rapikan(array$data): array
    {
        // Jurnal yang masih berstatus "sedang_dibaca" tidak boleh menyimpan nilai rating
        if ($data['status'] !== 'selesai') {
            $data['rating'] = null;
        }

        return $data;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JurnalBelajar;
use App\Models\KontenEdukasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurnalBelajarController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $jurnal = $user->jurnalBelajar()
            ->with('kontenEdukasi:id,judul')
            ->latest()
            ->paginate(10);

        $statistik = [
            'total' => $user->jurnalBelajar()->count(),
            'selesai' => $user->jurnalBelajar()->where('status', 'selesai')->count(),
            'rataRating' => $user->jurnalBelajar()->whereNotNull('rating')->avg('rating'),
        ];

        return view('jurnal.index', compact('jurnal', 'statistik'));
    }

    public function create(Request $request)
    {
        $sudahDijurnalkan = $request->user()->jurnalBelajar()->pluck('konten_edukasi_id');

        $daftarArtikel = KontenEdukasi::whereNotIn('id', $sudahDijurnalkan)
            ->orderBy('judul')
            ->get(['id', 'judul']);

        return view('jurnal.create', compact('daftarArtikel'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'konten_edukasi_id' => [
                'required',
                'exists:konten_edukasi,id',
                Rule::unique('jurnal_belajar', 'konten_edukasi_id')
                    ->where('user_id', $request->user()->id),
            ],
        ] + $this->aturanIsi());

        $request->user()->jurnalBelajar()->create($this->rapikan($data));

        return redirect()->route('jurnal.index')->with('status', 'Jurnal berhasil disimpan.');
    }

    public function edit(Request $request, JurnalBelajar $jurnal)
    {
        $this->pastikanPemilik($request, $jurnal);

        $jurnal->load('kontenEdukasi:id,judul');

        return view('jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, JurnalBelajar $jurnal)
    {
        $this->pastikanPemilik($request, $jurnal);

        $data = $request->validate($this->aturanIsi());

        $jurnal->update($this->rapikan($data));

        return redirect()->route('jurnal.index')->with('status', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Request $request, JurnalBelajar $jurnal)
    {
        $this->pastikanPemilik($request, $jurnal);

        $jurnal->delete();

        return redirect()->route('jurnal.index')->with('status', 'Jurnal berhasil dihapus.');
    }

    private function pastikanPemilik(Request $request, JurnalBelajar $jurnal): void
    {
        abort_if($jurnal->user_id !== $request->user()->id, 403);
    }

    private function aturanIsi(): array
    {
        return [
            'ringkasan' => 'required|string|min:20|max:1000',
            'status' => ['required', Rule::in(['sedang_dibaca', 'selesai'])],
            'rating' => ['required_if:status,selesai', 'nullable', 'integer', 'between:1,5'],
        ];
    }

    private function rapikan(array $data): array
    {
        // Jurnal yang masih dibaca tidak boleh menyimpan rating.
        if ($data['status'] !== 'selesai') {
            $data['rating'] = null;
        }

        return $data;
    }
}

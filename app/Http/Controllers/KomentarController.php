<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpanKomentarRequest;
use App\Models\Biota;
use App\Models\Komentar;
use Illuminate\Support\Facades\Gate;

class KomentarController extends Controller
{

    public function store(SimpanKomentarRequest $request, Biota $biota)
    {
        // dd($request->all());
        // --- TAMBAHKAN BLOK INI ---
        // $sudahKomen = $biota->komentar()->where('user_id', $request->user()->id)->exists();
        // if ($sudahKomen) {
        //     return back()->withErrors(['isi' => 'Kamu sudah memberikan komentar di biota ini.']);
        // }
        //
        $biota->komentar()->create([
            'user_id' => $request->user()->id,
            'isi' => $request->validated('isi'),
            'rating' => $request->validated('rating'),
        ]);

        return redirect(route('biota.show', $biota) . '#komentar')
            ->with('status', 'Komentar berhasil ditambahkan.');
    }


    public function edit(Komentar $komentar)
    {
        Gate::authorize('update', $komentar);

        return view('komentar.edit', compact('komentar'));
    }


    public function update(SimpanKomentarRequest $request, Komentar $komentar)
    {
        Gate::authorize('update', $komentar);

        $komentar->update(['isi' => $request->validated('isi')]);

        return redirect(route('biota.show', $komentar->biota) . '#komentar')
            ->with('status', 'Komentar berhasil diperbarui.');
    }

    /** DELETE */
    public function destroy(Komentar $komentar)
    {
        Gate::authorize('delete', $komentar);

        $biota = $komentar->biota;
        $komentar->delete();

        return redirect(route('biota.show', $biota) . '#komentar')
            ->with('status', 'Komentar berhasil dihapus.');
    }
}

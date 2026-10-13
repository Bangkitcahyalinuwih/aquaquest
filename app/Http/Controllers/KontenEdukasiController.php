<?php

namespace App\Http\Controllers;

use App\Models\KontenEdukasi;
use Illuminate\Http\Request;

class KontenEdukasiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100']);

        $konten = KontenEdukasi::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $kata = '%'.$request->q.'%';
                $query->where(fn ($w) => $w->where('judul', 'like', $kata)->orWhere('isi', 'like', $kata));
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('edukasi.index', compact('konten'));
    }

    public function show(KontenEdukasi $konten)
    {
        return view('edukasi.show', compact('konten'));
    }
}

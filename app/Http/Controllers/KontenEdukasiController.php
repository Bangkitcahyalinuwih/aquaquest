<?php

namespace App\Http\Controllers;

use App\Models\KontenEdukasi;

class KontenEdukasiController extends Controller
{
    public function index()
    {
        $konten = KontenEdukasi::latest()->paginate(9);

        return view('edukasi.index', compact('konten'));
    }

    public function show(KontenEdukasi $konten)
    {
        return view('edukasi.show', compact('konten'));
    }
}

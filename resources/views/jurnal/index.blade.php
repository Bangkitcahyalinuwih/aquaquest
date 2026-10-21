@extends('layouts.main')
@section('title', 'Jurnal Penyelam - AquaQuest')

@section('content')
<div class="max-w-5xl mx-auto py-6">

    {{-- Header & Tombol Tambah --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-cyan-800">📖 Jurnal Penyelam</h1>
            <p class="text-sm text-slate-500 mt-1">Catatan penemuan dan observasi biota air di lapangan.</p>
        </div>
        <a href="{{ route('jurnal.create') }}" class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium px-4 py-2.5 rounded-xl shadow-sm transition-colors text-sm">
            + Catat Temuan Baru
        </a>
    </div>

    {{-- Kondisional untuk Pesan Sukses (Flash Session) --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Data Jurnal --}}
    <div class="bg-white rounded-2xl shadow-sm border border-cyan-100 overflow-hidden">
        @if ($jurnals->isEmpty())
            <div class="p-12 text-center">
                <p class="text-slate-500 font-medium">Belum ada catatan jurnal penyelam.</p>
                <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Catat Temuan Baru" di kanan atas untuk memulai.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama Biota</th>
                            <th class="px-6 py-4">Lokasi Temuan</th>
                            <th class="px-6 py-4">Kondisi</th>
                            <th class="px-6 py-4">Catatan Observasi</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        {{-- Syarat 3 UTS: Direktif Perulangan foreach --}}
                        @foreach ($jurnals as $jurnal)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $jurnal->nama_biota }}</td>
                                <td class="px-6 py-4">{{ $jurnal->lokasi }}</td>
                                <td class="px-6 py-4">
                                    {{-- Syarat 3 UTS: Kondisional if untuk Status/Kondisi Data --}}
                                    @if ($jurnal->kondisi === 'sehat')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                            Sehat
                                        </span>
                                    @elseif ($jurnal->kondisi === 'terluka')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            Terluka
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">
                                            Langka
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 max-w-sm whitespace-normal break-words leading-relaxed">{{ $jurnal->catatan }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500">{{ $jurnal->user->name ?? 'Anonim' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-semibold border border-amber-200 transition-colors">
                                            Edit
                                        </a>
                                        {{-- Form Hapus (Syarat 4 & 5 UTS: HTTP DELETE + CSRF) --}}
                                        <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold border border-red-200 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
@extends('layouts.main')
@section('title', 'Catat Temuan Baru - AquaQuest')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <div class="mb-6">
        <a href="{{ route('jurnal.index') }}" class="text-sm text-cyan-600 hover:underline">&larr; Kembali ke Daftar Jurnal</a>
        <h1 class="text-2xl font-extrabold text-cyan-800 mt-2">Catat Temuan Biota Baru</h1>
        <p class="text-sm text-slate-500">Isi formulir di bawah ini untuk mendokumentasikan biota air yang kamu temukan.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-cyan-100">
        {{-- Syarat 4 UTS: HTTP POST dengan proteksi CSRF --}}
        <form action="{{ route('jurnal.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nama_biota" class="block mb-2 text-sm font-semibold text-slate-700">Nama Biota</label>
                <input type="text" name="nama_biota" id="nama_biota" value="{{ old('nama_biota') }}"
                    class="w-full rounded-xl border @error('nama_biota') border-red-500 bg-red-50/30 @else border-slate-300 bg-slate-50 @enderror p-3 text-sm focus:ring-cyan-500 focus:border-cyan-500"
                    placeholder="Contoh: Ikan Badut (Nemo)">
                @error('nama_biota')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lokasi" class="block mb-2 text-sm font-semibold text-slate-700">Lokasi Ditemukan</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}"
                    class="w-full rounded-xl border @error('lokasi') border-red-500 bg-red-50/30 @else border-slate-300 bg-slate-50 @enderror p-3 text-sm focus:ring-cyan-500 focus:border-cyan-500"
                    placeholder="Contoh: Pantai Pasir Putih, Situbondo">
                @error('lokasi')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kondisi" class="block mb-2 text-sm font-semibold text-slate-700">Kondisi Biota Saat Ditemukan</label>
                <select name="kondisi" id="kondisi"
                    class="w-full rounded-xl border @error('kondisi') border-red-500 bg-red-50/30 @else border-slate-300 bg-slate-50 @enderror p-3 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="sehat" {{ old('kondisi') === 'sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="terluka" {{ old('kondisi') === 'terluka' ? 'selected' : '' }}>Terluka / Butuh Penanganan</option>
                    <option value="langka" {{ old('kondisi') === 'langka' ? 'selected' : '' }}>Spesies Langka</option>
                </select>
                @error('kondisi')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="catatan" class="block mb-2 text-sm font-semibold text-slate-700">Catatan Observasi (Minimal 10 Karakter)</label>
                <textarea name="catatan" id="catatan" rows="4"
                    class="w-full rounded-xl border @error('catatan') border-red-500 bg-red-50/30 @else border-slate-300 bg-slate-50 @enderror p-3 text-sm focus:ring-cyan-500 focus:border-cyan-500"
                    placeholder="Ceritakan ciri-ciri atau perilaku biota saat ditemukan...">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm shadow-sm transition-colors">
                    Simpan Catatan
                </button>
                <a href="{{ route('jurnal.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl text-sm transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
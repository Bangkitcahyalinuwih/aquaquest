<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Dashboard Admin</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ([['Biota', $jumlahBiota], ['Edukasi', $jumlahEdukasi], ['Soal', $jumlahSoal], ['Kartu', $jumlahKartu], ['Pemain', $jumlahPemain], ['Sesi Kuis Selesai', $sesiSelesai]] as [$label, $angka])
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-primary">{{ $angka }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $label }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Pemain Teratas</h2>
                @forelse ($pemainTeratas as $i => $p)
                    <div class="flex justify-between py-2 border-t text-sm">
                        <span>{{ $i + 1 }}. {{ $p->name }}</span>
                        <span class="text-slate-600">Level {{ $p->level }} - {{ $p->total_xp }} XP</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada pemain.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold mb-3">Sesi Kuis Terbaru</h2>
                @forelse ($sesiTerbaru as $s)
                    <div class="flex justify-between py-2 border-t text-sm">
                        <span>{{ $s->user->name }}</span>
                        <span class="text-slate-600">{{ $s->jumlah_benar }}/5 benar -
                            {{ $s->selesai_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada sesi kuis.</p>
                @endforelse
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.biota.create') }}" class="px-4 py-2 bg-primary text-white text-sm rounded-md">+
                Biota</a>
            <a href="{{ route('admin.edukasi.create') }}" class="px-4 py-2 bg-primary text-white text-sm rounded-md">+
                Edukasi</a>
            @if (Route::has('admin.soal.create'))
                <a href="{{ route('admin.soal.create') }}" class="px-4 py-2 bg-primary text-white text-sm rounded-md">+
                    Soal</a>
            @endif
            @if (Route::has('admin.kartu.create'))
                <a href="{{ route('admin.kartu.create') }}"
                    class="px-4 py-2 bg-primary text-white text-sm rounded-md">+ Kartu</a>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    {{-- Hero. Gradien ditulis langsung supaya tidak bergantung versi Tailwind. --}}
    <section style="background: linear-gradient(135deg, #0E7490, #22D3EE)" class="text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16 sm:py-24 text-center">
            <p class="text-5xl mb-4" aria-hidden="true">🌊</p>
            <h1 class="text-3xl sm:text-5xl font-bold">Jelajahi Kehidupan Bawah Laut Indonesia</h1>
            <p class="mt-4 text-lg text-cyan-50 max-w-2xl mx-auto">
                Pelajari biota laut, mainkan kuis, kumpulkan kartu koleksi, dan jadi bagian dari upaya menjaga lautan
                (SDG 14).
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                @guest
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 bg-white text-primary font-semibold rounded-md hover:bg-cyan-50">Daftar Gratis</a>
                    <a href="{{ route('biota.index') }}"
                        class="px-6 py-3 border border-white text-white font-semibold rounded-md hover:bg-white/10">Lihat
                        Ensiklopedia</a>
                @else
                    <a href="{{ route('kuis.index') }}"
                        class="px-6 py-3 bg-white text-primary font-semibold rounded-md hover:bg-cyan-50">Mulai Kuis</a>
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-3 border border-white text-white font-semibold rounded-md hover:bg-white/10">Dashboard
                        Saya</a>
                @endguest
            </div>
        </div>
    </section>

    {{-- Statistik --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 -mt-8">
        <div class="grid grid-cols-3 gap-3 bg-white rounded-lg shadow-lg p-4 text-center">
            <div>
                <p class="text-2xl font-bold text-primary">{{ $jumlahBiota }}</p>
                <p class="text-xs text-slate-500">Biota</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-primary">{{ $jumlahSoal }}</p>
                <p class="text-xs text-slate-500">Soal Kuis</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-primary">{{ $jumlahPemain }}</p>
                <p class="text-xs text-slate-500">Pemain</p>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
        <h2 class="text-2xl font-bold text-center text-primary">Yang Bisa Kamu Lakukan</h2>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ([
                    ['📖', 'Ensiklopedia', 'Kenali biota laut lengkap dengan habitat dan peta persebarannya.', 'biota.index'],
                    ['🎓', 'Materi Edukasi', 'Baca artikel singkat tentang ekosistem laut dan cara menjaganya.', 'edukasi.index'],
                    ['🎮', 'Kuis', 'Jawab soal bertema laut, kumpulkan XP, dan naikkan level.', 'kuis.index'],
                    ['🃏', 'Koleksi Kartu', 'Buka kartu biota setiap XP-mu mencapai syaratnya.', 'kartu.index'],
                ] as [$ikon, $judul, $isi, $rute])
                <a href="{{ route($rute) }}" class="bg-white rounded-lg shadow p-5 hover:shadow-md transition">
                    <p class="text-3xl" aria-hidden="true">{{ $ikon }}</p>
                    <h3 class="mt-3 font-semibold text-primary">{{ $judul }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ $isi }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Biota pilihan --}}
    @if ($biotaPilihan->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 pb-12">
            <div class="flex items-end justify-between mb-6">
                <h2 class="text-2xl font-bold text-primary">Kenalan dengan Biota Laut</h2>
                <a href="{{ route('biota.index') }}" class="text-sm text-primary hover:underline">Lihat semua</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($biotaPilihan as $item)
                    <x-biota-card :biota="$item" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Edukasi terbaru --}}
    @if ($edukasiTerbaru->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 pb-12">
            <div class="flex items-end justify-between mb-6">
                <h2 class="text-2xl font-bold text-primary">Materi Terbaru</h2>
                <a href="{{ route('edukasi.index') }}" class="text-sm text-primary hover:underline">Lihat semua</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($edukasiTerbaru as $artikel)
                    <a href="{{ route('edukasi.show', $artikel) }}"
                        class="bg-white rounded-lg shadow p-5 hover:shadow-md transition">
                        <h3 class="font-semibold text-primary">{{ $artikel->judul }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ Str::limit($artikel->isi, 110) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Ajakan untuk tamu --}}
    @guest
        <section class="max-w-5xl mx-auto px-4 sm:px-6 pb-4">
            <div class="rounded-lg p-8 text-center text-white" style="background:#0E7490">
                <h2 class="text-2xl font-bold">Siap jadi penjaga lautan?</h2>
                <p class="mt-2 text-cyan-50">Daftar sekarang dan mulai kumpulkan XP serta kartu koleksimu.</p>
                <a href="{{ route('register') }}"
                    class="inline-block mt-5 px-6 py-3 bg-white text-primary font-semibold rounded-md">Daftar Sekarang</a>
            </div>
        </section>
    @endguest
</x-app-layout>
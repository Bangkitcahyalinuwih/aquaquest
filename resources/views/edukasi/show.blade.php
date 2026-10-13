<x-app-layout>
    @php
        $gambarMateri = [
            'mengenal-sdg-14-ekosistem-lautan' => 'sdg-14-sistem-laut.jpg',
            'mengapa-terumbu-karang-penting' => 'terumbu-karang.jpg',
            'bahaya-sampah-plastik-bagi-biota-laut' => 'sampah-plastik.jpg',
            'padang-lamun-penjaga-pesisir-yang-sering-terlupakan' => 'padang-lamun.jpg',
            'memahami-status-konservasi-iucn' => 'iucn.jpg',
            'cara-sederhana-menjaga-laut-dari-rumah' => 'menjaga-laut-from-home.jpg',
        ];

        $namaGambar = $gambarMateri[$konten->slug] ?? 'sdg-14-sistem-laut.jpg';
    @endphp

    <!-- Container Utama Halaman -->
    <div class="relative min-h-screen bg-[#ecf8f9] overflow-hidden py-10 px-4 sm:px-6">

        <!-- Layer Gambar: Transparan/Memudar di Atas, Makin Jelas di Bawah -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
             style="background-image: url('{{ asset('images/edukasi/' . $namaGambar) }}');
                    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,1) 100%);
                    mask-image: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,1) 100%);">
        </div>

        <!-- Kartu Teks Utama -->
        <div class="relative z-10 max-w-3xl mx-auto py-8 px-6 sm:px-10 rounded-3xl bg-white/80 shadow-xl border border-white/80">
            <a href="{{ route('edukasi.index') }}" class="text-sm text-teal-600 hover:text-teal-800 font-medium transition-colors">&larr; Kembali ke daftar</a>

            <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight">{{ $konten->judul }}</h1>

            @if ($konten->gambar_url)
                <img src="{{ $konten->gambar_url }}" alt="{{ $konten->judul }}"
                    class="mt-4 w-full max-h-80 object-cover rounded-xl shadow">
            @endif

            <article class="mt-6 leading-relaxed text-slate-700 whitespace-pre-line text-base sm:text-lg">{{ $konten->isi }}</article>

            @if ($konten->biota)
                <a href="{{ route('biota.show', $konten->biota) }}" class="inline-block mt-6 text-teal-600 hover:text-teal-800 hover:underline font-semibold">
                    Lihat biota terkait: {{ $konten->biota->nama }}
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <a href="{{ route('edukasi.index') }}" class="text-sm text-secondary">&larr; Kembali ke daftar</a>

        <h1 class="mt-2 text-3xl font-bold text-primary">{{ $konten->judul }}</h1>

        @if ($konten->gambar_url)
            <img src="{{ $konten->gambar_url }}" alt="{{ $konten->judul }}"
                class="mt-4 w-full max-h-80 object-cover rounded-lg shadow">
        @endif

        <article class="mt-6 leading-relaxed text-slate-700 whitespace-pre-line">{{ $konten->isi }}</article>

        @if ($konten->biota)
            <a href="{{ route('biota.show', $konten->biota) }}" class="inline-block mt-6 text-primary hover:underline">
                Lihat biota terkait: {{ $konten->biota->nama }}
            </a>
        @endif
    </div>
</x-app-layout>
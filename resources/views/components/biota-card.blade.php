@props(['biota'])

<a href="{{ route('biota.show', $biota) }}"
    class="block bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
    @if ($biota->gambar_url)
        <img src="{{ $biota->gambar_url }}" alt="{{ $biota->nama }}" class="h-44 w-full object-cover" loading="lazy">
    @else
        <div class="h-44 w-full flex items-center justify-center text-5xl" style="background:#CFFAFE" aria-hidden="true">🐠
        </div>
    @endif
    <div class="p-4">
        <span class="text-xs px-2 py-0.5 rounded bg-secondary/20 text-primary">{{ $biota->kategori }}</span>
        <h3 class="mt-2 font-semibold text-primary">{{ $biota->nama }}</h3>
        <p class="text-xs italic text-slate-500">{{ $biota->nama_latin }}</p>
        <p class="text-sm text-slate-600 mt-2">{{ Str::limit($biota->deskripsi, 90) }}</p>
    </div>
</a>
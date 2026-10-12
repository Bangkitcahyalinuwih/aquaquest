<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Materi Edukasi</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6">
        <form method="GET" action="{{ route('edukasi.index') }}" class="flex gap-3 mb-6">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari materi..."
                class="flex-1 border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
            <button type="submit" class="px-5 py-2 bg-primary text-white rounded-md hover:bg-cyan-800">Cari</button>
        </form>

        @if ($konten->isEmpty())
            <div class="bg-white rounded-lg shadow p-10 text-center text-slate-500">Belum ada materi yang cocok.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($konten as $item)
                    <a href="{{ route('edukasi.show', $item) }}"
                        class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden flex flex-col">
                        @if ($item->gambar_url)
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="h-40 w-full object-cover"
                                loading="lazy">
                        @endif
                        <div class="p-5">
                            <h2 class="font-semibold text-primary">{{ $item->judul }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ Str::limit($item->isi, 130) }}</p>
                            <span class="inline-block mt-3 text-sm text-secondary font-medium">Baca selengkapnya</span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $konten->links() }}</div>
        @endif
    </div>
</x-app-layout>
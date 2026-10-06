@extends('layouts.main')
@section('title', 'Edukasi - AquaQuest')
@section('content')

<div class="relative left-1/2 -translate-x-1/2 w-screen -mt-8 -mb-4">

    {{-- Hero --}}
    <div class="bg-gradient-to-r from-primary to-secondary">
        <div class="px-6 py-10">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Edukasi</h1>
            <p class="text-sm text-white/80">Pelajari dunia perairan lewat artikel singkat.</p>
        </div>
    </div>

    {{-- Daftar konten --}}
    <div class="px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($konten as $item)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-200 overflow-hidden flex flex-col">
                    <div class="h-2 bg-gradient-to-r from-accent to-secondary"></div>

                    <div class="p-5 flex flex-col flex-1">
                        <div class="w-10 h-10 rounded-xl bg-accent/30 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold text-primary">{{ $item->judul }}</h2>
                        <p class="text-sm text-gray-600 mt-2 flex-1">{{ Str::limit($item->isi, 120) }}</p>

                        <a href="{{ route('edukasi.show', $item) }}"
                           class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-secondary hover:text-primary transition">
                            Baca selengkapnya
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">{{ $konten->links() }}</div>
    </div>
</div>

@endsection
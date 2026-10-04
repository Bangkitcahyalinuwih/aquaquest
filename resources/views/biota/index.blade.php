@extends('layouts.main')
@section('title', 'Ensiklopedia - AquaQuest')
@section('content')

<div class="relative left-1/2 -translate-x-1/2 w-screen -mt-8 -mb-4">

    <div class="bg-gradient-to-r from-primary to-secondary">
        <div class="px-6 py-10">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Ensiklopedia Biota</h1>
            <p class="text-sm text-white/80">Kumpulkan dan kenali makhluk hidup perairan.</p>
        </div>
    </div>

{{-- Daftar Kartu --}}
    <div class="px-6 py-8">
       <div class="px-6 py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 justify-items-center">
                @foreach ($biota as $item)
                    <a href="{{ route('biota.show', $item) }}" class="group block w-full max-w-[280px]">
                    {{-- Bingkai luar kartu --}}
                    <div class="rounded-2xl p-1.5 bg-gradient-to-br from-primary via-secondary to-accent
                                shadow-md group-hover:shadow-2xl group-hover:-translate-y-2 group-hover:rotate-1
                                transition duration-300">

                        {{-- Isi kartu --}}
                        <div class="bg-surface rounded-xl p-3 aspect-[5/7] flex flex-col overflow-hidden">

                            <div class="flex items-center justify-between gap-2">
                                <h2 class="font-bold text-primary leading-tight line-clamp-1">{{ $item->nama }}</h2>
                                @if ($item->status_konservasi)
                                    <span class="w-8 h-8 shrink-0 rounded-full bg-accent text-primary text-[11px] font-bold
                                                 flex items-center justify-center ring-2 ring-white shadow">
                                        {{ $item->status_konservasi }}
                                    </span>
                                @endif
                            </div>

                            {{-- Area gambar --}}
                            <div class="mt-2 h-36 rounded-lg border-2 border-primary/70 overflow-hidden relative
                                        bg-gradient-to-b from-secondary to-accent">
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <svg class="absolute inset-0 w-full h-full text-white/40" viewBox="0 0 100 60" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" preserveAspectRatio="none">
                                        <path d="M0 20c8-8 16-8 25 0s17 8 25 0 17-8 25 0 17 8 25 0"/>
                                        <path d="M0 35c8-8 16-8 25 0s17 8 25 0 17-8 25 0 17 8 25 0"/>
                                        <path d="M0 50c8-8 16-8 25 0s17 8 25 0 17-8 25 0 17 8 25 0"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- kategori --}}
                            <div class="mt-2 flex items-center justify-between gap-2 px-2 py-1 rounded-md bg-primary text-white text-[11px]">
                                <span class="inline-flex items-center gap-1 font-medium">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    </svg>
                                    {{ $item->kategori }}
                                </span>
                                <span class="italic text-white/80 truncate">{{ $item->nama_latin }}</span>
                            </div>

                            {{-- deskripsi --}}
                            <div class="mt-2 flex-1 rounded-lg bg-white/80 border border-primary/10 p-2">
                                <p class="text-xs text-gray-600 line-clamp-4">{{ $item->deskripsi }}</p>
                            </div>

                            {{-- Footer --}}
                            <div class="mt-2 flex items-center justify-between text-[11px] text-primary">
                                <span class="inline-flex items-center gap-1 truncate">
                                    <svg class="w-3.5 h-3.5 text-secondary shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    {{ $item->habitat ?? '-' }}
                                </span>
                                <span class="inline-flex items-center gap-0.5 font-semibold text-secondary group-hover:gap-1.5 transition-all">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $biota->links() }}
        </div>
    </div>
</div>

@endsection
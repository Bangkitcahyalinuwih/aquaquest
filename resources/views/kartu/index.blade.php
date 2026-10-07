@extends('layouts.main')
@section('title', 'Koleksi Kartu - AquaQuest')
@section('content')

<div class="relative left-1/2 -translate-x-1/2 w-screen -mt-8 -mb-4">

    {{-- Hero --}}
    <div class="bg-gradient-to-r from-primary to-secondary">
        <div class="px-6 py-10">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Koleksi Kartu</h1>
            <p class="text-sm text-white/80">Total XP kamu: {{ $totalXp }}</p>
        </div>
    </div>

    {{-- Galeri --}}
    <div class="px-6 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($kartu as $item)
                @php $terbuka = $totalXp >= $item->xp_syarat; @endphp

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden text-center {{ $terbuka ? 'hover:shadow-xl hover:-translate-y-1 transition duration-200' : 'opacity-40 grayscale' }}">
                    <div class="h-2 bg-gradient-to-r from-accent to-secondary"></div>
                    <div class="p-5">
                        <div class="text-4xl">{{ $terbuka ? '🐢' : '🔒' }}</div>
                        <h3 class="font-bold text-primary mt-2">{{ $terbuka ? $item->nama : '???' }}</h3>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $terbuka ? $item->biota->nama : 'Butuh ' . $item->xp_syarat . ' XP' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
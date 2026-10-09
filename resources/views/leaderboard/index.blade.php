@extends('layouts.main')
@section('title', 'Peringkat - AquaQuest')
@section('content')

@php
    $daftar = collect($pemain instanceof \Illuminate\Pagination\AbstractPaginator ? $pemain->items() : $pemain)->values();
    $podium = $daftar->take(3);
    $lainnya = $daftar->slice(3);
    $maks = max(1, (int) $daftar->max('total_xp'));
    $urutPodium = [0 => 'order-2', 1 => 'order-1', 2 => 'order-3'];
    $tinggiBar = [0 => 'h-44', 1 => 'h-32', 2 => 'h-24'];
    $warnaBar = [
        0 => 'bg-gradient-to-t from-primary to-secondary',
        1 => 'bg-gradient-to-t from-secondary to-accent',
        2 => 'bg-gradient-to-t from-secondary/70 to-accent/80',
    ];
    $medali = ['🥇', '🥈', '🥉'];
@endphp

<div class="relative left-1/2 -translate-x-1/2 w-screen -mt-8 -mb-4">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-b-[3rem] bg-gradient-to-br from-primary via-primary to-secondary">
        <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="relative max-w-3xl mx-auto px-6 pt-12 pb-14">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-none text-white">Peringkat</h1>
            <p class="mt-3 text-white/80">Siapa yang paling dalam menyelam? Diurutkan dari total XP tertinggi.</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-6 py-10">
        @if ($daftar->isEmpty())
            <div class="py-12 text-center">
                <p class="text-5xl">🌊</p>
                <p class="mt-3 text-xl font-bold text-primary">Belum ada pemain di peringkat</p>
                <p class="text-sm text-gray-500 mt-1">Selesaikan satu kuis untuk jadi yang pertama.</p>
                <a href="{{ route('kuis.index') }}" class="mt-5 inline-block rounded-full bg-primary px-6 py-3 font-bold text-white hover:bg-secondary transition">Mulai kuis</a>
            </div>
        @else
            {{-- Podium sebagai batang --}}
            <div class="flex items-end justify-center gap-3 sm:gap-5">
                @foreach ($podium as $i => $item)
                    @php $saya = auth()->id() === ($item->id ?? null); @endphp
                    <div class="{{ $urutPodium[$i] }} w-28 sm:w-36 text-center">
                        <div class="text-4xl">{{ $medali[$i] }}</div>
                        <p class="mt-1 font-bold text-primary truncate">{{ $item->name }}</p>
                        @if ($saya)
                            <span class="inline-block rounded-full bg-primary px-2 py-0.5 text-xs font-medium text-white">Kamu</span>
                        @endif
                        <p class="text-sm text-gray-500 tabular-nums">{{ number_format($item->total_xp) }} XP</p>
                        <div class="mt-2 {{ $tinggiBar[$i] }} {{ $warnaBar[$i] }} rounded-t-2xl flex items-start justify-center pt-3">
                            <span class="text-3xl font-extrabold text-white">{{ $i + 1 }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="h-1 rounded-full bg-primary/15"></div>

            {{-- Posisi 4 dst: batang XP relatif --}}
            @if ($lainnya->isNotEmpty())
                <ul class="mt-8 space-y-2">
                    @foreach ($lainnya as $i => $item)
                        @php
                            $saya = auth()->id() === ($item->id ?? null);
                            $lebar = (int) round($item->total_xp / $maks * 100);
                        @endphp
                        <li class="relative overflow-hidden rounded-xl">
                            <div class="absolute inset-y-0 left-0 {{ $saya ? 'bg-secondary/25' : 'bg-accent/30' }}" style="width: {{ $lebar }}%"></div>
                            <div class="relative flex items-center gap-4 px-4 py-3">
                                <span class="w-8 text-lg font-extrabold text-primary/40 tabular-nums">{{ $i + 1 }}</span>
                                <span class="flex-1 truncate {{ $saya ? 'font-bold text-primary' : 'text-primary' }}">
                                    {{ $item->name }}
                                    @if ($saya)
                                        <span class="ml-2 rounded-full bg-primary px-2 py-0.5 text-xs font-medium text-white">Kamu</span>
                                    @endif
                                </span>
                                <span class="text-xs text-gray-500">Level {{ $item->level }}</span>
                                <span class="w-20 text-right font-bold text-primary tabular-nums">{{ number_format($item->total_xp) }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>
</div>

@endsection
@extends('layouts.main')
@section('title', 'Dashboard - AquaQuest')
@section('content')

@php
    $adaKartu = (bool) $kartuBerikutnya;
    if ($adaKartu) {
        $kebutuhan = $kartuBerikutnya->xp_syarat;
        $persen = $kebutuhan > 0 ? min(100, (int) floor($user->total_xp / $kebutuhan * 100)) : 100;
        $sisa = max(0, $kebutuhan - $user->total_xp);
    } else {
        $persen = 100;
    }
@endphp

<div class="relative left-1/2 -translate-x-1/2 w-screen -mt-8 -mb-4">

    {{-- Hero: level sebagai tipografi besar --}}
    <div class="relative overflow-hidden rounded-b-[3rem] bg-gradient-to-br from-primary via-primary to-secondary">
        <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="absolute right-24 bottom-6 h-20 w-20 rounded-full bg-accent/20"></div>

        <div class="relative max-w-4xl mx-auto px-6 pt-12 pb-16">
            <p class="text-white/80">Halo, {{ $user->name }} 👋</p>
            <h1 class="mt-1 text-7xl md:text-8xl font-extrabold leading-none text-white">
                Level <span class="text-accent">{{ $user->level }}</span>
            </h1>

            <div class="mt-8 flex items-center gap-6 text-white">
                <div>
                    <p class="text-3xl font-bold tabular-nums">{{ number_format($user->total_xp) }}</p>
                    <p class="text-sm text-white/70">Total XP</p>
                </div>
                <div class="h-10 w-px bg-white/30"></div>
                <div>
                    <p class="text-3xl font-bold">{{ $jumlahKartuDimiliki }}</p>
                    <p class="text-sm text-white/70">Kartu dimiliki</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-10">

        {{-- Perjalanan menuju kartu berikutnya --}}
        @if ($adaKartu)
            <h2 class="text-xl font-bold text-primary">Menuju kartu {{ $kartuBerikutnya->nama }}</h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ number_format($user->total_xp) }} dari {{ number_format($kebutuhan) }} XP, kurang {{ number_format($sisa) }} XP lagi.
            </p>

            <div class="mt-10 px-4">
                <div class="relative">
                    <div class="h-3 w-full rounded-full bg-primary/10"
                         role="progressbar" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-3 rounded-full bg-gradient-to-r from-accent to-secondary" style="width: {{ $persen }}%"></div>
                    </div>
                    <span class="absolute -top-8 -translate-x-1/2 text-3xl" style="left: {{ $persen }}%">🐢</span>
                    <span class="absolute -top-8 right-0 translate-x-1/2 text-3xl {{ $persen >= 100 ? '' : 'grayscale opacity-50' }}">🔒</span>
                </div>
            </div>
        @else
            <h2 class="text-xl font-bold text-primary">🎉 Semua kartu sudah terbuka</h2>
            <p class="text-sm text-gray-500 mt-1">Terus main kuis untuk naik peringkat.</p>
        @endif

        <a href="{{ route('kuis.index') }}"
           class="mt-10 inline-flex items-center gap-2 rounded-full bg-primary px-8 py-4 text-lg font-bold text-white hover:bg-secondary transition duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-secondary focus-visible:ring-offset-2">
            🎯 Main kuis sekarang
        </a>

        {{-- Menu lain --}}
        <div class="mt-12 divide-y divide-primary/10 border-y border-primary/10">
            <a href="{{ route('kartu.index') }}" class="group flex items-center justify-between py-5">
                <div class="flex items-center gap-4">
                    <span class="text-3xl">🃏</span>
                    <div>
                        <p class="font-bold text-primary">Koleksi kartu</p>
                        <p class="text-sm text-gray-500">{{ $jumlahKartuDimiliki }} kartu terbuka</p>
                    </div>
                </div>
                <span class="text-secondary text-xl transition group-hover:translate-x-1">→</span>
            </a>
            <a href="{{ route('leaderboard.index') }}" class="group flex items-center justify-between py-5">
                <div class="flex items-center gap-4">
                    <span class="text-3xl">🏆</span>
                    <div>
                        <p class="font-bold text-primary">Peringkat</p>
                        <p class="text-sm text-gray-500">Lihat posisimu di antara pemain lain</p>
                    </div>
                </div>
                <span class="text-secondary text-xl transition group-hover:translate-x-1">→</span>
            </a>
        </div>
    </div>
</div>

@endsection
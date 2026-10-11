@extends('layouts.main')
@section('title', 'Beranda - AquaQuest')
@section('content')

<div class="relative left-1/2 -translate-x-1/2 w-screen -mt-8 -mb-4">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-b-[3rem] bg-gradient-to-br from-primary via-primary to-secondary">
        <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="absolute left-10 bottom-6 h-20 w-20 rounded-full bg-accent/20"></div>

        <div class="relative max-w-5xl mx-auto px-6 pt-16 pb-20 text-center">
            <span class="inline-block rounded-full bg-white/15 px-4 py-1 text-xs font-medium text-white">
                Sistem Edukasi Biota Air
            </span>
            <h1 class="mt-4 text-4xl md:text-6xl font-extrabold leading-tight text-white">
                Selami dunia perairan, <span class="text-accent">kumpulkan kartunya</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-white/80">
                Kenali biota air lewat ensiklopedia dan materi singkat, uji pengetahuanmu lewat kuis, lalu buka kartu koleksi dari XP yang kamu kumpulkan.
            </p>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('biota.index') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 font-bold text-primary hover:bg-accent transition">
                    Jelajahi Ensiklopedia
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 rounded-full border-2 border-white/60 px-6 py-3 font-bold text-white hover:bg-white/10 transition">
                    Main Sekarang
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Fitur utama --}}
    <div class="max-w-5xl mx-auto px-6 py-14">
        <h2 class="text-2xl font-bold text-primary text-center">Apa yang bisa kamu lakukan di sini?</h2>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('biota.index') }}" class="group bg-white rounded-2xl shadow-sm p-6 hover:shadow-xl hover:-translate-y-1 transition duration-200">
                <div class="w-12 h-12 rounded-xl bg-accent/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="mt-4 font-bold text-primary">Ensiklopedia Biota</h3>
                <p class="mt-1 text-sm text-gray-600">Lihat kartu biota lengkap dengan habitat dan status konservasinya.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-secondary group-hover:gap-2 transition-all">
                    Buka
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </a>

            <a href="{{ route('edukasi.index') }}" class="group bg-white rounded-2xl shadow-sm p-6 hover:shadow-xl hover:-translate-y-1 transition duration-200">
                <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <h3 class="mt-4 font-bold text-primary">Materi Edukasi</h3>
                <p class="mt-1 text-sm text-gray-600">Baca artikel singkat tentang dunia perairan dan pelestariannya.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-secondary group-hover:gap-2 transition-all">
                    Baca
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </a>

            <a href="{{ route('dashboard') }}" class="group bg-white rounded-2xl shadow-sm p-6 hover:shadow-xl hover:-translate-y-1 transition duration-200">
                <div class="w-12 h-12 rounded-xl bg-accent/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                </div>
                <h3 class="mt-4 font-bold text-primary">Kuis dan Kartu Koleksi</h3>
                <p class="mt-1 text-sm text-gray-600">Jawab soal, kumpulkan XP, dan buka kartu biota yang terkunci.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-secondary group-hover:gap-2 transition-all">
                    Main
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </a>
        </div>

        {{-- Ajakan terakhir --}}
        <div class="mt-12 rounded-2xl bg-gradient-to-r from-primary to-secondary p-8 text-center">
            <h3 class="text-xl font-bold text-white">Siapa yang paling dalam menyelam?</h3>
            <p class="mt-1 text-sm text-white/80">Lihat posisimu di antara pemain lain.</p>
            <a href="{{ route('leaderboard.index') }}"
               class="mt-5 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 font-bold text-primary hover:bg-accent transition">
                Lihat Peringkat
            </a>
        </div>
    </div>
</div>

@endsection
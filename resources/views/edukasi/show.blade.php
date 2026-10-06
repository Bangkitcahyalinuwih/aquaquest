@extends('layouts.main')
@section('title', $konten->judul . ' - AquaQuest')
@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl overflow-hidden">
        <div class="px-6 py-8">
            <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-1 text-sm text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke daftar
            </a>
            <h1 class="text-3xl font-bold text-white mt-3">{{ $konten->judul }}</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 mt-6">
        <div class="leading-relaxed text-gray-700 whitespace-pre-line">{{ $konten->isi }}</div>
    </div>
</div>

@endsection
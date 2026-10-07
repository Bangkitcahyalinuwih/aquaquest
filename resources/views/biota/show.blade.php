@extends('layouts.main')
@section('title', $biota->nama . ' - AquaQuest')
@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl overflow-hidden">
        <div class="px-6 py-8">
            <a href="{{ route('biota.index') }}" class="inline-flex items-center gap-1 text-sm text-white/80 hover:text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke daftar
            </a>
            <h1 class="text-3xl font-bold text-white mt-3">{{ $biota->nama }}</h1>
            <p class="text-white/80 italic">{{ $biota->nama_latin }}</p>
        </div>
    </div>

    <div class="mt-6 space-y-4">

        {{-- Info singkat --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="w-9 h-9 rounded-xl bg-accent/30 flex items-center justify-center mb-2">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500">Kategori</p>
                <p class="font-semibold text-primary">{{ $biota->kategori }}</p>
            </div>

            @if ($biota->status_konservasi)
                <div class="bg-white rounded-2xl shadow-sm p-4">
                    <div class="w-9 h-9 rounded-xl bg-secondary/10 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500">Status konservasi</p>
                    <p class="font-semibold text-primary">{{ $biota->status_konservasi }}</p>
                </div>
            @endif

            @if ($biota->habitat)
                <div class="bg-white rounded-2xl shadow-sm p-4">
                    <div class="w-9 h-9 rounded-xl bg-accent/30 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500">Habitat</p>
                    <p class="font-semibold text-primary">{{ $biota->habitat }}</p>
                </div>
            @endif
        </div>

        {{-- Deskripsi --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-bold text-primary mb-2">Tentang biota ini</h2>
            <p class="leading-relaxed text-gray-700">{{ $biota->deskripsi }}</p>
        </div>

        {{-- Location --}}
        @if ($biota->latitude && $biota->longitude)
            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-dashed border-accent">
                <div class="flex items-center gap-2 text-primary font-semibold">
                    <svg class="w-5 h-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    Lokasi: {{ $biota->latitude }}, {{ $biota->longitude }}
                </div>
                @if ($biota->latitude && $biota->longitude)
    <div id="peta-biota" class="mt-4 rounded" style="height: 300px; z-index: 10;"></div>

    @push('scripts')
        <script>
            const peta = L.map('peta-biota').setView([{{ $biota->latitude }}, {{ $biota->longitude }}], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(peta);

            L.marker([{{ $biota->latitude }}, {{ $biota->longitude }}])
                .addTo(peta)
                .bindPopup('{{ $biota->nama }}');
        </script>
    @endpush
@endif
            </div>
        @endif
    </div>
</div>

@endsection
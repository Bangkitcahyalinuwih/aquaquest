@php
    $targetAktif = auth()->check() 
        ? \App\Models\Target::where('user_id', auth()->id())->where('status', 'Belum Selesai')->first() 
        : null;
@endphp

@if ($targetAktif)
    <div class="bg-gradient-to-r from-cyan-600 to-primary text-white px-4 py-2.5 text-center text-sm font-medium shadow-sm flex items-center justify-center gap-2">
        <span>🎯 <strong>Target Aktifmu:</strong> {{ $targetAktif->judul_target }}</span>
        <a href="{{ route('targets.index') }}" class="underline text-xs bg-white/20 hover:bg-white/30 px-2 py-0.5 rounded transition">
            Lihat Detail
        </a>
    </div>
@endif
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Dashboard</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 space-y-6">

        <h2 class="text-2xl font-bold text-primary">Halo, {{ $user->name }}</h2>

        {{-- Pengguna baru --}}
        @unless ($pernahMain)
            <div class="rounded-lg p-6 text-white" style="background:#0E7490">
                <h3 class="text-lg font-semibold">Selamat datang di AquaQuest!</h3>
                <p class="mt-1 text-cyan-50">Mainkan kuis pertamamu untuk mendapat XP dan membuka kartu koleksi pertama.</p>
                <a href="{{ route('kuis.index') }}"
                    class="inline-block mt-4 px-5 py-2 bg-white text-primary font-semibold rounded-md">Mulai Kuis</a>
            </div>
        @endunless

        {{-- Ringkasan --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-3xl font-bold text-primary">{{ $user->level }}</p>
                <p class="text-xs text-slate-500">Level</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-3xl font-bold text-primary">{{ $user->total_xp }}</p>
                <p class="text-xs text-slate-500">Total XP</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-3xl font-bold text-primary">{{ $jumlahKartuDimiliki }}</p>
                <p class="text-xs text-slate-500">Kartu Dimiliki</p>
            </div>
        </div>

        {{-- Progres kartu berikutnya --}}
        @if ($kartuBerikutnya)
            @php $persen = min(100, (int) floor($user->total_xp / max(1, $kartuBerikutnya->xp_syarat) * 100)); @endphp
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm">
                    Kartu berikutnya: <strong>{{ $kartuBerikutnya->nama }}</strong>
                    ({{ $user->total_xp }} / {{ $kartuBerikutnya->xp_syarat }} XP)
                </p>
                <div class="mt-2 w-full bg-slate-200 rounded-full h-3">
                    <div class="bg-accent h-3 rounded-full" style="width: {{ $persen }}%"></div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-5 text-accent font-semibold">
                Kamu sudah membuka semua kartu yang tersedia!
            </div>
        @endif

        {{-- Status XP harian --}}
        <div
            class="rounded-lg border p-4 text-sm {{ $sudahMainHariIni ? 'bg-amber-50 border-amber-200 text-amber-800' : 'bg-green-50 border-green-200 text-green-800' }}">
            @if ($sudahMainHariIni)
                Kamu sudah mendapat jatah XP hari ini. Sesi tambahan tetap bisa dimainkan sebagai latihan, dan XP bisa
                didapat lagi besok.
            @else
                Jatah XP hari ini belum dipakai. Selesaikan satu kuis untuk mendapat XP.
            @endif
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('kuis.index') }}" class="px-4 py-2 bg-primary text-white rounded-md text-sm">Main Kuis</a>
            <a href="{{ route('kartu.index') }}"
                class="px-4 py-2 border border-primary text-primary rounded-md text-sm">Lihat Koleksi</a>
            <a href="{{ route('leaderboard.index') }}" class="px-4 py-2 border text-slate-600 rounded-md text-sm">Lihat
                Peringkat</a>
        </div>
    </div>
</x-app-layout>
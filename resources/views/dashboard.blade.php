<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold">Halo, {{ $user->name }}</h1>
        <p>Level {{ $user->level }} — {{ $user->total_xp }} XP</p>
        <p>Kartu yang kamu miliki: {{ $jumlahKartuDimiliki }}</p>

        @if ($kartuBerikutnya)
            <p>
                Kartu berikutnya "{{ $kartuBerikutnya->nama }}" terbuka di {{ $kartuBerikutnya->xp_syarat }} XP
                (kurang {{ $kartuBerikutnya->xp_syarat - $user->total_xp }} XP lagi).
            </p>
        @else
            <p>Kamu sudah membuka semua kartu yang tersedia!</p>
        @endif
    </div>
</x-app-layout>

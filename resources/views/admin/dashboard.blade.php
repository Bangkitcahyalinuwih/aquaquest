<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <ul>
            <li>Biota: {{ $jumlahBiota }}</li>
            <li>Edukasi: {{ $jumlahEdukasi }}</li>
            <li>Soal: {{ $jumlahSoal }}</li>
            <li>Kartu: {{ $jumlahKartu }}</li>
            <li>Pemain: {{ $jumlahPemain }}</li>
            <li>Sesi kuis selesai: {{ $sesiSelesai }}</li>
        </ul>
    </div>
</x-app-layout>

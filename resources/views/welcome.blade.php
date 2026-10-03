<!-- Memanggil kerangka utama yang berisi Navbar buatanmu -->
@extends('main')

<!-- Memberi judul khusus untuk halaman ini -->
@section('title', 'Beranda - AquaQuest')

<!-- Mengisi bagian konten di bawah Navbar -->
@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-cyan-100 text-center mt-10">
        <h1 class="text-4xl font-extrabold text-cyan-800 mb-4">Selamat Datang di AquaQuest 🌊</h1>
        <p class="text-slate-600 mb-6">Navbar di atas sudah terhubung sempurna dengan halaman beranda ini melalui sistem routing Laravel.</p>
        
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Mulai Belajar
        </button>
    </div>
@endsection
@php
    $pengguna = auth()->user();
    $admin = $pengguna?->role === 'admin';

    // Aman dipakai walau route tujuan belum dibuat tim backend: jatuh ke '#'.
    $url = fn(string $nama) => \Illuminate\Support\Facades\Route::has($nama) ? route($nama) : '#';

    if ($admin) {
        $menu = [
            ['Dashboard Admin', 'admin.dashboard', 'admin.dashboard'],
            ['Kelola Biota', 'admin.biota.index', 'admin.biota.*'],
            ['Kelola Edukasi', 'admin.edukasi.index', 'admin.edukasi.*'],
            ['Kelola Soal', 'admin.soal.index', 'admin.soal.*'],
            ['Kelola Kartu', 'admin.kartu.index', 'admin.kartu.*'],
        ];
    } else {
        $menu = [
            ['Beranda', 'home', 'home'],
            ['Ensiklopedia', 'biota.index', 'biota.*'],
            ['Materi Edukasi', 'edukasi.index', 'edukasi.*'],
            ['Kuis', 'kuis.index', 'kuis.*'],
        ];

        if ($pengguna) {
            $menu[] = ['Koleksi', 'kartu.index', 'kartu.*'];
            $menu[] = ['Peringkat', 'leaderboard.index', 'leaderboard.*'];
            $menu[] = ['Dashboard', 'dashboard', 'dashboard'];
            $menu[] = ['Jurnal', 'jurnal.index', 'jurnal.*'];
        }
    }
@endphp

<nav x-data="{ buka: false, dropdown: false, atTop: true }" 
     x-init="atTop = (window.pageYOffset || document.documentElement.scrollTop) < 20; window.addEventListener('scroll', () => { atTop = (window.pageYOffset || document.documentElement.scrollTop) < 20 })"
     :class="atTop ? 'bg-white border-b shadow-sm' : 'bg-white/30 backdrop-blur-md border-b border-white/20 shadow-none'"
     class="sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
           <a href="{{ $admin ? $url('admin.dashboard') : $url('home') }}"
                class="flex items-center gap-2 text2xl font-bold text-primary">
                <img src="{{ asset('images/logo-aquaquest.png') }}" 
                     alt="AquaQuest Logo" 
                     class="h-12 sm:h-16 w-auto mix-blend-multiply drop-shadow-sm">
                <span>AquaQuest</span>
            </a>

            {{-- Menu desktop --}}
            <div class="hidden lg:flex items-center gap-1">
                @foreach ($menu as [$label, $nama, $pola])
                    <a href="{{ $url($nama) }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs($pola) ? 'text-primary bg-secondary/10' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Sisi kanan desktop --}}
            <div class="hidden lg:flex items-center gap-2">
                @guest
                    <a href="{{ route('login') }}"
                        class="px-3 py-2 text-sm font-medium text-slate-600 hover:text-primary">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-md hover:bg-cyan-800">Daftar</a>
                @else
                    <div class="relative" @click.outside="dropdown = false">
                        <button @click="dropdown = !dropdown"
                            class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary">
                            {{ $pengguna->name }}
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z" />
                            </svg>
                        </button>
                        <div x-show="dropdown" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-1 z-50"
                            style="display:none">
                            @if ($admin)
                                <a href="{{ $url('home') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Lihat Situs</a>
                            @else
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profil</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Tombol hamburger (mobile) --}}
            <button @click="buka = !buka" class="lg:hidden p-2 rounded-md text-slate-600 hover:bg-slate-100"
                aria-label="Buka menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path x-show="!buka" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="buka" stroke-linecap="round" d="M6 6l12 12M18 6L6 18" style="display:none" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu mobile --}}
    <div x-show="buka" x-transition class="lg:hidden border-t px-4 py-3 space-y-1" style="display:none">
        @foreach ($menu as [$label, $nama, $pola])
            <a href="{{ $url($nama) }}"
                class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs($pola) ? 'text-primary bg-secondary/10' : 'text-slate-700 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
        @endforeach

        @guest
            <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-slate-700">Masuk</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-semibold text-primary">Daftar</a>
        @else
            @if ($admin)
                <a href="{{ $url('home') }}" class="block px-3 py-2 text-base font-medium text-slate-700">Lihat Situs</a>
            @else
                <a href="{{ route('profile.edit') }}"
                    class="block px-3 py-2 text-base font-medium text-slate-700">Profil</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full text-left px-3 py-2 text-base font-medium text-slate-700">Keluar</button>
            </form>
        @endguest
    </div>
</nav>

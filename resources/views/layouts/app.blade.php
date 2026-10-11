@php
    $pengguna = Auth::user();
    $aktif = 'block py-2 px-3 text-white bg-cyan-600 rounded md:bg-transparent md:text-cyan-600 md:p-0';
    $biasa = 'block py-2 px-3 text-slate-600 rounded hover:bg-cyan-100 md:hover:bg-transparent md:hover:text-cyan-500 md:p-0';
    $menu = [
        ['Dashboard', route('dashboard'), request()->routeIs('dashboard')],
        ['Kuis', route('kuis.index'), request()->routeIs('kuis.*')],
        ['Koleksi', route('kartu.index'), request()->routeIs('kartu.*')],
        ['Peringkat', route('leaderboard.index'), request()->routeIs('leaderboard.*')],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $attributes->get('title') ? $attributes->get('title') . ' - ' : '' }}{{ config('app.name', 'AquaQuest') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none !important}</style>
    @stack('styles')
</head>
<body class="bg-sky-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen overflow-x-hidden">

    <!-- NAVBAR PEMAIN (setelah login) -->
    <nav x-data="{ buka: false, akun: false }"
         class="bg-white/90 backdrop-blur-md border-b border-cyan-100 fixed w-full z-20 top-0 start-0 shadow-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-extrabold whitespace-nowrap text-cyan-700">🌊 AquaQuest</span>
            </a>

            <button @click="buka = !buka" type="button" aria-label="Buka menu"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-cyan-500 rounded-lg md:hidden hover:bg-cyan-50 focus:outline-none focus:ring-2 focus:ring-cyan-200">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <div :class="buka ? 'block' : 'hidden'" class="w-full md:flex md:w-auto md:items-center md:gap-6">

                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-cyan-100 rounded-lg bg-cyan-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                    @foreach ($menu as [$label, $href, $sedang])
                        <li><a href="{{ $href }}" class="{{ $sedang ? $aktif : $biasa }}">{{ $label }}</a></li>
                    @endforeach
                </ul>

                {{-- Akun --}}
                <div class="mt-3 md:mt-0 md:border-l md:border-cyan-100 md:pl-6">
                    <div class="relative inline-block" @click.outside="akun = false">
                       <button @click="akun = !akun" type="button" title="{{ $pengguna->name }}"
                                class="flex items-center gap-1.5 rounded-full border border-cyan-100 bg-white p-1 pr-2 hover:bg-cyan-50 focus:outline-none focus:ring-2 focus:ring-cyan-200 transition">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-cyan-600 text-sm font-bold text-white uppercase">
                                {{ mb_substr($pengguna->name, 0, 1) }}
                            </span>
                            {{-- Nama hanya tampil di menu HP --}}
                            <span class="md:hidden text-sm font-medium text-slate-700">{{ ucfirst($pengguna->name) }}</span>
                            <svg class="h-4 w-4 shrink-0 text-slate-400 transition-transform duration-200" :class="akun ? 'rotate-180' : ''"
                                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <div x-show="akun" x-cloak x-transition
                             class="absolute left-0 md:left-auto md:right-0 top-full mt-2 z-50 w-56 overflow-hidden rounded-xl bg-white shadow-xl ring-1 ring-black/5">
                            <div class="border-b border-cyan-100 bg-cyan-50 px-4 py-3">
                                <p class="truncate text-sm font-semibold text-slate-800">{{ ucfirst($pengguna->name) }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $pengguna->email }}</p>
                                <div class="mt-2 flex items-center gap-2 text-xs font-semibold">
                                    <span class="rounded-full bg-cyan-600 px-2 py-0.5 text-white">Level {{ $pengguna->level }}</span>
                                    <span class="text-cyan-700">{{ number_format($pengguna->total_xp) }} XP</span>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-cyan-50">Profil</a>
                            <a href="{{ url('/') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-cyan-50">Ke Beranda</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow mt-24 p-4 max-w-screen-xl mx-auto w-full">
        @isset($header)
            <div class="mb-4">{{ $header }}</div>
        @endisset
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-cyan-100 mt-auto">
        <div class="max-w-screen-xl p-4 py-6 mx-auto text-center text-sm text-slate-500">
            © 2026 <span class="text-cyan-600 font-semibold">AquaQuest</span>. Sistem Edukasi Biota Air (Dinas Perikanan).
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
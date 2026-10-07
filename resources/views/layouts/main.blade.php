<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AquaQuest')</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen">

    <!-- NAVBAR UTAMA -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-cyan-100 fixed w-full z-20 top-0 start-0 shadow-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-extrabold whitespace-nowrap text-cyan-700">🌊 AquaQuest</span>
            </a>
            
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-cyan-500 rounded-lg md:hidden hover:bg-cyan-50 focus:outline-none focus:ring-2 focus:ring-cyan-200">
                <span class="sr-only">Buka menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                @php
                    $aktif   = 'block py-2 px-3 text-white bg-cyan-600 rounded md:bg-transparent md:text-cyan-600 md:p-0';
                    $biasa   = 'block py-2 px-3 text-slate-600 rounded hover:bg-cyan-100 md:hover:bg-transparent md:hover:text-cyan-500 md:p-0';
                @endphp

                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-cyan-100 rounded-lg bg-cyan-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                    <li>
                        <a href="{{ url('/') }}" class="{{ request()->is('/') ? $aktif : $biasa }}">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('biota.index') }}" class="{{ request()->routeIs('biota.*') ? $aktif : $biasa }}">Ensiklopedia</a>
                    </li>
                    <li>
                        <a href="#" class="{{ $biasa }}">Materi Edukasi</a>
                    </li>
                    <li>
                        <a href="#" class="{{ $biasa }}">Game & Kuis</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA (Diberi mt-24 agar tidak tertutup navbar fixed) -->
    <main class="flex-grow mt-24 p-4 max-w-screen-xl mx-auto w-full">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-cyan-100 mt-auto">
        <div class="max-w-screen-xl p-4 py-6 mx-auto text-center text-sm text-slate-500">
            © 2026 <span class="text-cyan-600 font-semibold">AquaQuest</span>. Sistem Edukasi Biota Air (Dinas Perikanan).
        </div>
    </footer>
@stack('scripts')
</body>
</html>
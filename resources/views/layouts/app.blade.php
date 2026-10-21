<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'AquaQuest') }}</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-teal-50 text-slate-900 min-h-screen flex flex-col">
    @include('layouts.navigation')

    {{-- Header Halaman --}}
    @isset($header)
        <header class="bg-white border-b">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6">{{ $header }}</div>
        </header>
    @endisset

    {{-- Banner Target Aktif di Semua Halaman --}}
    <x-target-banner />

    {{-- Status Flash Message --}}
    @if (session('status'))
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 mt-4">
            <div class="rounded-md border border-green-300 bg-green-50 text-green-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        </div>
    @endif

    {{-- Konten Utama (Slot dipanggil 1 kali saja) --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    @stack('scripts')
</body>

</html>
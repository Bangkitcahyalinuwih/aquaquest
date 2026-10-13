<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AquaQuest') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-teal-50 text-slate-900 min-h-screen flex flex-col">
    @include('layouts.navigation')

    <main class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full sm:max-w-md bg-white shadow-md rounded-lg px-6 py-6">
            {{ $slot }}
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Ensiklopedia Biota</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6">
        <form method="GET" action="{{ route('biota.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama biota..."
                class="flex-1 border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
            <select name="kategori"
                class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                <option value="">Semua kategori</option>
                @foreach ($daftarKategori as $k)
                    <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2 bg-primary text-white rounded-md hover:bg-cyan-800">Cari</button>
            @if (request()->filled('q') || request()->filled('kategori'))
                <a href="{{ route('biota.index') }}"
                    class="px-3 py-2 text-sm text-slate-600 hover:underline self-center">Reset</a>
            @endif
        </form>

        @if ($biota->isEmpty())
            <div class="bg-white rounded-lg shadow p-10 text-center text-slate-500">
                Tidak ada biota yang cocok dengan pencarianmu.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($biota as $item)
                    <x-biota-card :biota="$item" />
                @endforeach
            </div>
            <div class="mt-6">{{ $biota->links() }}</div>
        @endif
    </div>
</x-app-layout>
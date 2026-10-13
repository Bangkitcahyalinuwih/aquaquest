<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-primary">Kelola Biota</h1>
            <a href="{{ route('admin.biota.create') }}"
                class="px-4 py-2 bg-primary text-white text-sm rounded-md hover:bg-cyan-800">+ Tambah Biota</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6">
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Gambar</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($biota as $item)
                        @php
                            $warnaKategori = match ($item->kategori) {
                                'Ikan' => 'bg-blue-100 text-blue-700',
                                'Mamalia Laut' => 'bg-indigo-100 text-indigo-700',
                                'Reptil Laut' => 'bg-emerald-100 text-emerald-700',
                                'Moluska' => 'bg-purple-100 text-purple-700',
                                'Terumbu Karang' => 'bg-orange-100 text-orange-700',
                                'Krustasea' => 'bg-rose-100 text-rose-700',
                                default => 'bg-slate-100 text-slate-700',
                            };

                            $warnaStatus = match ($item->status_konservasi) {
                                'LC' => 'bg-green-100 text-green-700',
                                'NT' => 'bg-blue-100 text-blue-700',
                                'VU' => 'bg-yellow-100 text-yellow-700',
                                'EN' => 'bg-orange-100 text-orange-700',
                                'CR' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <tr class="border-t">
                            <td class="px-4 py-3">
                                @if ($item->gambar_url)
                                    <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}"
                                        class="h-12 w-16 object-cover rounded">
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $item->nama }}</p>
                                <p class="text-xs text-slate-500 italic">{{ $item->nama_latin }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $warnaKategori }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $warnaStatus }}">
                                    {{ $item->status_konservasi ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 space-x-3 whitespace-nowrap flex items-center mt-2">
                                <a href="{{ route('admin.biota.edit', $item) }}"
                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <x-admin.tombol-hapus :action="route('admin.biota.destroy', $item)" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $biota->links() }}</div>
    </div>
</x-app-layout>

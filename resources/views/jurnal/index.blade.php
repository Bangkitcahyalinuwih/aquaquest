<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-primary">Jurnal belajar saya</h1>
            <a href="{{ route('jurnal.create') }}"
                class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-md hover:bg-cyan-800">
                + Tambah jurnal
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                <p class="text-sm text-slate-500">Total jurnal</p>
                <p class="text-2xl font-bold text-slate-800">{{ $statistik['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                <p class="text-sm text-slate-500">Selesai dibaca</p>
                <p class="text-2xl font-bold text-slate-800">{{ $statistik['selesai'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                <p class="text-sm text-slate-500">Rata-rata rating</p>
                <p class="text-2xl font-bold text-slate-800">
                    {{ $statistik['rataRating'] ? number_format($statistik['rataRating'], 1, ',', '.') : '-' }}
                </p>
            </div>
        </div>

        @if ($jurnal->isEmpty())
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-10 text-center">
                <p class="text-lg font-semibold text-slate-800">Mulai jurnal pertamamu</p>
                <p class="text-sm text-slate-500 mt-1 mb-4">Baca artikel edukasi, lalu catat ringkasannya di sini.</p>
                <a href="{{ route('jurnal.create') }}"
                    class="inline-block px-4 py-2 text-sm font-semibold text-white bg-primary rounded-md hover:bg-cyan-800">
                    Tambah jurnal
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-600">
                        <tr>
                            <th class="px-4 py-3 font-medium">Artikel</th>
                            <th class="px-4 py-3 font-medium">Ringkasan</th>
                            <th class="px-4 py-3 font-medium text-center">Rating</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Target</th> <!-- Kolom Target Baru -->
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($jurnal as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $item->kontenEdukasi->judul }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ Str::limit($item->ringkasan, 60) }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->rating ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->status === 'selesai')
                                        <span class="inline-block rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-medium">Selesai</span>
                                    @else
                                        <span class="inline-block rounded-full bg-yellow-100 text-yellow-700 px-3 py-1 text-xs font-medium">Sedang dibaca</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    {{ $item->target_selesai ? $item->target_selesai->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('jurnal.edit', $item) }}"
                                            class="text-primary hover:underline">Edit</a>
                                        <form action="{{ route('jurnal.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus jurnal ini?')"
                                                class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $jurnal->links() }}</div>
        @endif
    </div>
</x-app-layout>
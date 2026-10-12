<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">
        <!-- SIDEBAR ADMIN -->
        <aside class="w-64 bg-white border-r border-cyan-100 hidden md:block">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li><a href="{{ route('admin.biota.index') }}"
                            class="flex items-center p-2 text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-50 transition"><span
                                class="ms-3">Kelola Biota</span></a></li>
                    <li><a href="{{ route('admin.edukasi.index') }}"
                            class="flex items-center p-2 text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-50 transition"><span
                                class="ms-3">Kelola Edukasi</span></a></li>
                    <li>
                        <a href="{{ route('admin.soal.index') }}"
                            class="flex items-center p-2 text-slate-900 rounded-lg bg-cyan-50">
                            <span class="ms-3 font-bold text-cyan-700">Kelola Soal</span>
                        </a>
                    </li>
                    <li><a href="{{ route('admin.kartu.index') }}"
                            class="flex items-center p-2 text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-50 transition"><span
                                class="ms-3">Kelola Kartu</span></a></li>
                </ul>
            </div>
        </aside>

        <!-- KONTEN -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-cyan-800">Kelola Soal Kuis</h1>
                    <p class="text-slate-500 text-sm mt-1">Manajemen pertanyaan kuis berbasis teks dan gambar.</p>
                </div>
                <a href="{{ route('admin.soal.create') }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition-all">+
                    Tambah Soal</a>
            </div>

            <div class="bg-white shadow-sm border border-cyan-100 rounded-xl overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-cyan-100">
                        <tr>
                            <th class="px-5 py-4">Pertanyaan</th>
                            <th class="px-5 py-4">Tipe</th>
                            <th class="px-5 py-4">Biota</th>
                            <th class="px-5 py-4 text-center">Jawaban</th>
                            <th class="px-5 py-4 text-center">Poin</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($soal as $item)
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                                <td class="px-5 py-3 font-medium text-slate-800">{{ Str::limit($item->pertanyaan, 70) }}
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $item->tipe === 'gambar' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($item->tipe) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $item->biota?->nama ?? '-' }}</td>
                                <td class="px-5 py-3 text-center font-bold text-green-600">
                                    {{ strtoupper($item->jawaban_benar) }}</td>
                                <td class="px-5 py-3 text-center text-amber-600 font-semibold">{{ $item->poin }}</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center space-x-3">
                                    <a href="{{ route('admin.soal.edit', $item) }}"
                                        class="inline-block text-blue-500 hover:text-blue-700 transition"
                                        title="Edit">Edit</a>
                                    <x-admin.tombol-hapus :action="route('admin.soal.destroy', $item)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-500">Belum ada data soal.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $soal->links() }}</div>
        </main>
    </div>
</x-app-layout>

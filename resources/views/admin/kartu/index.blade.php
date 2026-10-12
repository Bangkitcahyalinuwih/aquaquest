<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">
        <!-- SIDEBAR ADMIN (Pastikan Kelola Kartu yang diberi warna Cyan di sini) -->
        <aside class="w-64 bg-white border-r border-cyan-100 hidden md:block">
            <!-- (Sama seperti sidebar di atas, namun beri class bg-cyan-50 pada menu Kartu) -->
        </aside>

        <!-- KONTEN -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-cyan-800">Kelola Kartu Koleksi</h1>
                    <p class="text-slate-500 text-sm mt-1">Manajemen kartu *reward* yang bisa didapatkan pemain.</p>
                </div>
                <a href="{{ route('admin.kartu.create') }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition-all">+
                    Tambah Kartu</a>
            </div>

            <div class="bg-white shadow-sm border border-cyan-100 rounded-xl overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-cyan-100">
                        <tr>
                            <th class="px-5 py-4">Gambar</th>
                            <th class="px-5 py-4">Nama Kartu</th>
                            <th class="px-5 py-4">Biota</th>
                            <th class="px-5 py-4">Syarat XP</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kartu as $item)
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                                <td class="px-5 py-3">
                                    <img src="{{ $item->gambar_url }}"
                                        class="h-16 w-12 object-cover rounded-md shadow-sm border border-slate-200">
                                </td>
                                <td class="px-5 py-3 font-bold text-slate-800">{{ $item->nama }}</td>
                                <td class="px-5 py-3 text-cyan-600 font-medium">{{ $item->biota->nama }}</td>
                                <td class="px-5 py-3 font-mono text-amber-600 font-bold">{{ $item->xp_syarat }} XP</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center space-x-3">
                                    <a href="{{ route('admin.kartu.edit', $item) }}"
                                        class="inline-block text-blue-500 hover:text-blue-700 transition"
                                        title="Edit">Edit</a>
                                    <x-admin.tombol-hapus :action="route('admin.kartu.destroy', $item)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada data kartu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>

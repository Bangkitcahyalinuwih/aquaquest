<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">
        <!-- SIDEBAR ADMIN -->
        <aside class="w-64 bg-white border-r border-cyan-100 hidden md:block" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('admin.biota.index') }}"
                            class="flex items-center p-2 text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-50 group transition">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3">Kelola Biota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.edukasi.index') }}"
                            class="flex items-center p-2 text-slate-900 rounded-lg bg-cyan-50 group">
                            <svg class="w-5 h-5 text-cyan-500 transition" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M18 5h-2.5V3.5A1.5 1.5 0 0 0 14 2H6a1.5 1.5 0 0 0-1.5 1.5V5H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1ZM6.5 3.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5V5h-7V3.5ZM17 16H3V7h14v9Z" />
                            </svg>
                            <span class="ms-3">Kelola Edukasi</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- AREA KONTEN UTAMA -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-cyan-800">Kelola Edukasi</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola artikel dan materi pembelajaran untuk pengguna.</p>
                </div>
                <a href="{{ route('admin.edukasi.create') }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-sm font-semibold rounded-xl hover:from-cyan-600 hover:to-cyan-700 shadow-md hover:shadow-lg transition-all">+
                    Tambah Konten</a>
            </div>

            <!-- TABEL KONTEN -->
            <div class="bg-white shadow-sm border border-cyan-100 rounded-xl overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-cyan-100">
                        <tr>
                            <th class="px-5 py-4">Gambar</th>
                            <th class="px-5 py-4">Judul Artikel</th>
                            <th class="px-5 py-4">Biota Terkait</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($konten as $item)
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                                <td class="px-5 py-3">
                                    @if ($item->gambar_url)
                                        <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}"
                                            class="h-14 w-20 object-cover rounded-lg shadow-sm border border-slate-200">
                                    @else
                                        <div
                                            class="h-14 w-20 bg-slate-100 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 text-xs">
                                            Tanpa Gambar</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <p class="font-bold text-slate-800">{{ $item->judul }}</p>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($item->biota)
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-cyan-100 text-cyan-700 border border-cyan-200">
                                            {{ $item->biota->nama }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                            Umum
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-center space-x-3">
                                    <a href="{{ route('admin.edukasi.edit', $item) }}"
                                        class="inline-block text-blue-500 hover:text-blue-700 transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <x-admin.tombol-hapus :action="route('admin.edukasi.destroy', $item)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada artikel
                                    edukasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $konten->links() }}</div>
        </main>
    </div>
</x-app-layout>

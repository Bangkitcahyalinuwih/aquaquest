<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">

        <!-- SIDEBAR ADMIN FLOWBITE -->
        <aside class="w-64 bg-white border-r border-cyan-100 hidden md:block" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-900 rounded-lg bg-cyan-50 group">
                            <svg class="w-5 h-5 text-cyan-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            </svg>
                            <span class="ms-3">Kelola Biota</span>
                        </a>
                    </li>
                    <!-- Menu admin lain bisa ditambahkan di sini nanti -->
                </ul>
            </div>
        </aside>

        <!-- AREA KONTEN UTAMA -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-extrabold text-cyan-800">Kelola Data Biota</h1>
                
                <!-- TOMBOL TAMBAH DATA (Logika Dila) -->
                <a href="{{ route('admin.biota.create') }}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all shadow-sm">
                    + Tambah Biota
                </a>
            </div>

            <!-- ALERT SESSION STATUS (Logika Dila) -->
            @if (session('status'))
                <div class="p-4 mb-6 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200" role="alert">
                    <span class="font-bold">Berhasil!</span> {{ session('status') }}
                </div>
            @endif

            <!-- TABEL FLOWBITE -->
            <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-cyan-100 bg-white">
                <table class="w-full text-sm text-left rtl:text-right text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-cyan-50 border-b border-cyan-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Biota</th>
                            <th scope="col" class="px-6 py-4">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <!-- LOOPING DATA BIOTA (Logika Dila) -->
                        @foreach ($biota as $item)
                        <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">
                                {{ $item->nama }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-cyan-100 text-cyan-800 text-xs font-medium px-2.5 py-0.5 rounded border border-cyan-300">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-4">
                                <!-- TOMBOL EDIT (Logika Dila) -->
                                <a href="{{ route('admin.biota.edit', $item) }}" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">Edit</a>
                                
                                <!-- FORM HAPUS (Logika Dila) -->
                                <form action="{{ route('admin.biota.destroy', $item) }}" method="POST" class="inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus {{ $item->nama }}?')" class="font-medium text-red-600 hover:text-red-800 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

            <!-- PAGINASI (Logika Dila) -->
            <div class="mt-6">
                {{ $biota->links() }}
            </div>
        </main>

    </div>
</x-app-layout>
<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">

        <!-- SIDEBAR ADMIN FLOWBITE -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:block" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="#"
                            class="flex items-center p-2 text-slate-900 rounded-lg bg-cyan-50 group transition-colors">
                            <svg class="w-5 h-5 text-cyan-600 transition duration-75" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3 font-semibold text-cyan-800">Kelola Biota</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- AREA KONTEN UTAMA -->
        <main class="flex-1 p-6 md:p-8 w-full">

            <!-- HEADER SECTION -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Kelola Data Biota</h1>
                    <p class="text-sm text-slate-500 mt-1">Manajemen ensiklopedia biota air, tambah, perbarui, atau
                        hapus data.</p>
                </div>

                <a href="{{ route('admin.biota.create') }}"
                    class="inline-flex items-center justify-center text-white bg-[#00838F] hover:bg-[#006064] focus:ring-4 focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Biota
                </a>
            </div>

            <!-- ALERT SESSION STATUS -->
            @if (session('status'))
                <div class="flex items-center p-4 mb-6 text-sm text-emerald-900 rounded-lg bg-emerald-50 border border-emerald-200 shadow-sm animate-fade-in-down"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-5 h-5 me-3 text-emerald-600" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div>
                        <span class="font-bold">Berhasil!</span> {{ session('status') }}
                    </div>
                </div>
            @endif

            <!-- TABEL FLOWBITE -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold text-slate-900">Nama Biota</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-slate-900">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-slate-900 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">

                            @forelse ($biota as $item)
                                <!-- LOGIKA WARNA KATEGORI -->
                                @php
                                    $badgeColor = match (strtolower(trim($item->kategori))) {
                                        'reptil laut' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'ikan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'mamalia laut',
                                        'mamalia air'
                                            => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'terumbu karang', 'koral' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'moluska' => 'bg-orange-50 text-orange-700 border-orange-200',
                                        'krustasea', 'crustacea' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'ubur-ubur' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        default
                                            => 'bg-slate-100 text-slate-700 border-slate-200', // Warna bawaan jika tidak masuk kategori atas
                                    };
                                @endphp

                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $item->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- Menerapkan warna dari variabel $badgeColor -->
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $badgeColor }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('admin.biota.edit', $item) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:text-blue-800 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.biota.destroy', $item) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus {{ $item->nama }}? Data tidak dapat dikembalikan.')"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:text-red-800 transition-colors">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada data biota</h3>
                                        <p class="mt-1 text-sm text-slate-500">Mulai dengan menambahkan biota air
                                            pertama ke ensiklopedia.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.biota.create') }}"
                                                class="inline-flex items-center rounded-md bg-[#00838F] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#006064] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                                                Tambah Data Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            @if ($biota->hasPages())
                <div class="mt-6">
                    {{ $biota->links() }}
                </div>
            @endif

        </main>
    </div>
</x-app-layout>

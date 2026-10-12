<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">

        <!-- SIDEBAR ADMIN -->
        <aside class="w-64 bg-white border-r border-cyan-100 hidden md:block" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('admin.biota.index') }}"
                            class="flex items-center p-2 text-slate-900 rounded-lg bg-cyan-50 group">
                            <svg class="w-5 h-5 text-cyan-500 transition duration-75" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3">Kelola Biota</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- AREA KONTEN UTAMA -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-cyan-800">Tambah Data Biota</h1>
                <p class="text-slate-500 text-sm mt-1">Masukkan detail informasi biota air yang baru ke dalam
                    ensiklopedia.</p>
            </div>

            <!-- CARD FORMULIR -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-cyan-100 max-w-4xl">
                {{-- WAJIB ada enctype agar bisa upload gambar --}}
                <form action="{{ route('admin.biota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Memanggil isi form dari _form.blade.php --}}
                    @include('admin.biota._form')

                    <!-- TOMBOL AKSI -->
                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <button type="submit"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center transition-all shadow-sm">
                            Simpan Data
                        </button>
                        <a href="{{ route('admin.biota.index') }}"
                            class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 font-medium rounded-lg text-sm px-6 py-2.5 text-center transition-all shadow-sm">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>

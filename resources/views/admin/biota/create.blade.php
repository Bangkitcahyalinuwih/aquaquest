<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">

        <!-- SIDEBAR ADMIN (Sama dengan halaman Index) -->
        <aside class="w-64 bg-white border-r border-cyan-100 hidden md:block" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('admin.biota.index') }}" class="flex items-center p-2 text-slate-900 rounded-lg bg-cyan-50 group">
                            <svg class="w-5 h-5 text-cyan-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
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
                <p class="text-slate-500 text-sm mt-1">Masukkan detail informasi biota air yang baru ke dalam ensiklopedia.</p>
            </div>

            <!-- CARD FORMULIR -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-cyan-100">
                <form action="{{ route('admin.biota.store') }}" method="POST">
                    @csrf
                    
                    <!-- GRID 2 KOLOM -->
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        
                        <!-- Input Nama -->
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-slate-900">Nama Biota</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="bg-slate-50 border @error('nama') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Contoh: Penyu Hijau">
                            @error('nama') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Nama Latin -->
                        <div>
                            <label for="nama_latin" class="block mb-2 text-sm font-medium text-slate-900">Nama Latin</label>
                            <input type="text" name="nama_latin" id="nama_latin" value="{{ old('nama_latin') }}" class="bg-slate-50 border @error('nama_latin') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm font-italic" placeholder="Contoh: Chelonia mydas">
                            @error('nama_latin') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Kategori -->
                        <div>
                            <label for="kategori" class="block mb-2 text-sm font-medium text-slate-900">Kategori</label>
                            <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" class="bg-slate-50 border @error('kategori') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm" placeholder="Contoh: Reptil Laut">
                            @error('kategori') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Habitat -->
                        <div>
                            <label for="habitat" class="block mb-2 text-sm font-medium text-slate-900">Habitat</label>
                            <input type="text" name="habitat" id="habitat" value="{{ old('habitat') }}" class="bg-slate-50 border @error('habitat') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm" placeholder="Contoh: Terumbu Karang">
                            @error('habitat') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Status Konservasi -->
                        <div>
                            <label for="status_konservasi" class="block mb-2 text-sm font-medium text-slate-900">Status Konservasi</label>
                            <input type="text" name="status_konservasi" id="status_konservasi" value="{{ old('status_konservasi') }}" class="bg-slate-50 border @error('status_konservasi') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm" placeholder="Contoh: Terancam Punah (Endangered)">
                            @error('status_konservasi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <!-- GRID LOKASI (Peta) -->
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Input Latitude -->
                        <div>
                            <label for="latitude" class="block mb-2 text-sm font-medium text-slate-900">Latitude (Garis Lintang)</label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" class="bg-slate-50 border @error('latitude') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm" placeholder="Contoh: -8.409518">
                            @error('latitude') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Longitude -->
                        <div>
                            <label for="longitude" class="block mb-2 text-sm font-medium text-slate-900">Longitude (Garis Bujur)</label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" class="bg-slate-50 border @error('longitude') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm" placeholder="Contoh: 115.188919">
                            @error('longitude') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Input Deskripsi (Full Width) -->
                    <div class="mb-6">
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-slate-900">Deskripsi Biota</label>
                        <textarea name="deskripsi" id="deskripsi" rows="5" class="bg-slate-50 border @error('deskripsi') border-red-500 @else border-slate-300 @enderror text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 shadow-sm" placeholder="Tuliskan deskripsi lengkap mengenai biota ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="flex items-center gap-4 mt-8 pt-4 border-t border-slate-100">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center transition-all shadow-sm">
                            Simpan Data
                        </button>
                        <a href="{{ route('admin.biota.index') }}" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 font-medium rounded-lg text-sm px-6 py-2.5 text-center transition-all shadow-sm">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
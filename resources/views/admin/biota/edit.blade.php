<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl font-bold text-cyan-800">Edit Data Biota</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui detail informasi biota air yang ada di dalam ensiklopedia.</p>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 md:p-8">
            <form action="{{ route('admin.biota.update', $biota) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Biota -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Biota</label>
                        <input type="text" name="nama" value="{{ old('nama', $biota->nama) }}"
                            placeholder="Contoh: Penyu Hijau"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Latin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Latin</label>
                        <input type="text" name="nama_latin" value="{{ old('nama_latin', $biota->nama_latin) }}"
                            placeholder="Contoh: Chelonia mydas"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('nama_latin')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $biota->kategori) }}"
                            placeholder="Contoh: Reptil Laut"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Habitat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Habitat</label>
                        <input type="text" name="habitat" value="{{ old('habitat', $biota->habitat) }}"
                            placeholder="Contoh: Terumbu Karang"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('habitat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Konservasi -->
                    <div class="md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Konservasi</label>
                        <input type="text" name="status_konservasi"
                            value="{{ old('status_konservasi', $biota->status_konservasi) }}"
                            placeholder="Contoh: Terancam Punah (Endangered)"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('status_konservasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Empty Space for Grid Balance -->
                    <div class="hidden md:block"></div>

                    <!-- Latitude -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Latitude (Garis Lintang)</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $biota->latitude) }}"
                            placeholder="Contoh: -8.409518"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('latitude')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Longitude (Garis Bujur)</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $biota->longitude) }}"
                            placeholder="Contoh: 115.188919"
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-2.5 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">
                        @error('longitude')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Biota -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Biota</label>
                        <textarea name="deskripsi" rows="5" placeholder="Tuliskan deskripsi lengkap mengenai biota ini..."
                            class="w-full rounded-lg border border-gray-200 bg-slate-50/50 p-3 text-sm text-gray-800 focus:bg-white focus:border-cyan-600 focus:ring-1 focus:ring-cyan-600 transition-colors">{{ old('deskripsi', $biota->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit"
                        class="bg-[#00838F] hover:bg-[#006064] text-white font-medium rounded-lg text-sm px-6 py-2.5 shadow-sm transition-colors">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.biota.index') }}"
                        class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg text-sm px-6 py-2.5 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

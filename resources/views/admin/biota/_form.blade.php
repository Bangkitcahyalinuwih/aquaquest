@php $b = $biota ?? null; @endphp

<div class="grid gap-6 md:grid-cols-2">

    <!-- Input Nama -->
    <div>
        <label for="nama" class="block mb-2 text-sm font-bold text-slate-700">Nama Biota</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $b?->nama) }}" required
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Contoh: Penyu Hijau">
        @error('nama')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Nama Latin -->
    <div>
        <label for="nama_latin" class="block mb-2 text-sm font-bold text-slate-700">Nama Latin</label>
        <input type="text" name="nama_latin" id="nama_latin" value="{{ old('nama_latin', $b?->nama_latin) }}"
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm italic"
            placeholder="Contoh: Chelonia mydas">
        @error('nama_latin')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Kategori -->
    <div>
        <label for="kategori" class="block mb-2 text-sm font-bold text-slate-700">Kategori</label>
        <input type="text" name="kategori" id="kategori" list="daftar-kategori"
            value="{{ old('kategori', $b?->kategori) }}" required
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Pilih atau ketik kategori...">
        <datalist id="daftar-kategori">
            @foreach (['Ikan', 'Mamalia Laut', 'Reptil Laut', 'Moluska', 'Terumbu Karang', 'Krustasea'] as $k)
                <option value="{{ $k }}">
            @endforeach
        </datalist>
        @error('kategori')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Status Konservasi -->
    <div>
        <label for="status_konservasi" class="block mb-2 text-sm font-bold text-slate-700">Status Konservasi (LC, NT,
            VU, EN, CR)</label>
        <input type="text" name="status_konservasi" id="status_konservasi"
            value="{{ old('status_konservasi', $b?->status_konservasi) }}"
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Contoh: EN">
        @error('status_konservasi')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Habitat (Full Width) -->
    <div class="md:col-span-2">
        <label for="habitat" class="block mb-2 text-sm font-bold text-slate-700">Habitat</label>
        <input type="text" name="habitat" id="habitat" value="{{ old('habitat', $b?->habitat) }}"
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Contoh: Perairan tropis dan terumbu karang">
        @error('habitat')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Deskripsi (Full Width) -->
    <div class="md:col-span-2">
        <label for="deskripsi" class="block mb-2 text-sm font-bold text-slate-700">Deskripsi Biota</label>
        <textarea name="deskripsi" id="deskripsi" rows="5" required
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Tuliskan deskripsi lengkap mengenai biota ini...">{{ old('deskripsi', $b?->deskripsi) }}</textarea>
        @error('deskripsi')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Koordinat -->
    <div>
        <label for="latitude" class="block mb-2 text-sm font-bold text-slate-700">Latitude (Garis Lintang)</label>
        <input type="number" step="any" name="latitude" id="latitude"
            value="{{ old('latitude', $b?->latitude) }}"
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Contoh: -8.409518">
        @error('latitude')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="longitude" class="block mb-2 text-sm font-bold text-slate-700">Longitude (Garis Bujur)</label>
        <input type="number" step="any" name="longitude" id="longitude"
            value="{{ old('longitude', $b?->longitude) }}"
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Contoh: 115.188919">
        @error('longitude')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Gambar yang Dipercantik (Full Width) -->
    <div class="md:col-span-2">
        <label for="gambar" class="block mb-2 text-sm font-bold text-slate-700">Gambar Biota (jpg, png, webp; maks. 2
            MB)</label>
        @if ($b?->gambar_url)
            <img src="{{ $b->gambar_url }}" alt="Gambar saat ini"
                class="h-32 object-cover rounded-xl mt-1 mb-3 shadow-sm border border-slate-200">
        @endif
        <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp"
            class="block w-full text-sm text-slate-500 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 shadow-sm
            file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-800 hover:file:bg-cyan-200 file:cursor-pointer transition-all">
        @error('gambar')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

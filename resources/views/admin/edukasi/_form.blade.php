@php $k = $konten ?? null; @endphp

<div class="grid gap-6">
    <!-- Input Judul -->
    <div>
        <label for="judul" class="block mb-2 text-sm font-bold text-slate-700">Judul Artikel</label>
        <input type="text" name="judul" id="judul" value="{{ old('judul', $k?->judul) }}" required
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm"
            placeholder="Contoh: Mengapa Terumbu Karang Penting?">
        @error('judul')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Pilihan Biota Terkait -->
    <div>
        <label for="biota_id" class="block mb-2 text-sm font-bold text-slate-700">Biota Terkait (Opsional)</label>
        <select name="biota_id" id="biota_id"
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm cursor-pointer">
            <option value="">Artikel Umum (Tidak terikat pada hewan tertentu)</option>
            @foreach ($daftarBiota as $b)
                <option value="{{ $b->id }}" @selected(old('biota_id', $k?->biota_id) == $b->id)>{{ $b->nama }}</option>
            @endforeach
        </select>
        @error('biota_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Isi Artikel -->
    <div>
        <label for="isi" class="block mb-2 text-sm font-bold text-slate-700">Isi Artikel</label>
        <textarea name="isi" id="isi" rows="12" required
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all shadow-sm leading-relaxed"
            placeholder="Tuliskan materi edukasi selengkapnya di sini...">{{ old('isi', $k?->isi) }}</textarea>
        @error('isi')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Input Gambar -->
    <div>
        <label for="gambar" class="block mb-2 text-sm font-bold text-slate-700">Gambar (Opsional; jpg, png, webp;
            maks. 2 MB)</label>
        @if ($k?->gambar_url)
            <img src="{{ $k->gambar_url }}" alt="Gambar saat ini"
                class="h-40 object-cover rounded-xl mt-1 mb-3 shadow-sm border border-slate-200">
        @endif
        <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp"
            class="block w-full text-sm text-slate-500 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 shadow-sm
            file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-800 hover:file:bg-cyan-200 file:cursor-pointer transition-all">
        @error('gambar')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

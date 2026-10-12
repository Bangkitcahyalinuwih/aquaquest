@php $k = $kartu ?? null; @endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="biota_id" class="block mb-2 text-sm font-bold text-slate-700">Pilih Biota</label>
        <select name="biota_id" id="biota_id" required
            class="block w-full p-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500">
            <option value="">-- Pilih Biota --</option>
            @foreach ($daftarBiota as $b)
                <option value="{{ $b->id }}" @selected(old('biota_id', $k?->biota_id) == $b->id)>{{ $b->nama }}</option>
            @endforeach
        </select>
        <p class="text-xs text-slate-500 mt-1">Hanya biota yang belum punya kartu yang ditampilkan.</p>
        @error('biota_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nama" class="block mb-2 text-sm font-bold text-slate-700">Nama Kartu</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $k?->nama) }}" required
            class="block w-full p-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500">
        @error('nama')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="xp_syarat" class="block mb-2 text-sm font-bold text-slate-700">Syarat XP untuk membuka</label>
        <input type="number" name="xp_syarat" id="xp_syarat" min="0"
            value="{{ old('xp_syarat', $k?->xp_syarat) }}" required
            class="block w-full p-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500">
        @error('xp_syarat')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="gambar" class="block mb-2 text-sm font-bold text-slate-700">Gambar Kartu (Wajib saat
            membuat)</label>
        @if ($k?->gambar_url)
            <img src="{{ $k->gambar_url }}" class="h-32 rounded-lg mt-1 mb-3 border border-slate-200">
        @endif
        <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" @required(!$k)
            class="block w-full text-sm bg-slate-50 border border-slate-200 rounded-xl file:mr-4 file:py-3 file:px-4 file:border-0 file:bg-cyan-100 file:text-cyan-800">
        @error('gambar')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

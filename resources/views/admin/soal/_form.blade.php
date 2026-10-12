@php $s = $soal ?? null; @endphp

<div class="grid gap-6" x-data="{ tipe: '{{ old('tipe', $s?->tipe ?? 'teks') }}' }">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="tipe" class="block mb-2 text-sm font-bold text-slate-700">Tipe Soal</label>
            <select name="tipe" id="tipe" x-model="tipe"
                class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500 focus:border-cyan-500">
                <option value="teks">Teks</option>
                <option value="gambar">Tebak Gambar</option>
            </select>
            @error('tipe')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="biota_id" class="block mb-2 text-sm font-bold text-slate-700">Biota Terkait (Opsional)</label>
            <select name="biota_id" id="biota_id"
                class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500 focus:border-cyan-500">
                <option value="">Soal Umum</option>
                @foreach ($daftarBiota as $b)
                    <option value="{{ $b->id }}" @selected(old('biota_id', $s?->biota_id) == $b->id)>{{ $b->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label for="pertanyaan" class="block mb-2 text-sm font-bold text-slate-700">Pertanyaan</label>
        <textarea name="pertanyaan" id="pertanyaan" rows="3" required
            class="block w-full p-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500">{{ old('pertanyaan', $s?->pertanyaan) }}</textarea>
        @error('pertanyaan')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- HANYA MUNCUL JIKA TIPE = GAMBAR -->
    <div x-show="tipe === 'gambar'" style="display:none" class="p-4 bg-purple-50 rounded-xl border border-purple-100">
        <label for="gambar" class="block mb-2 text-sm font-bold text-slate-700">Gambar Soal (Wajib untuk tebak
            gambar)</label>
        @if ($s?->gambar_url)
            <img src="{{ $s->gambar_url }}" class="h-24 rounded-lg mt-1 mb-3 border border-slate-200">
        @endif
        <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp"
            class="block w-full text-sm bg-white border border-slate-200 rounded-lg file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-purple-100 file:text-purple-700">
        @error('gambar')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach (['a', 'b', 'c', 'd'] as $o)
            <div>
                <label for="opsi_{{ $o }}" class="block mb-2 text-sm font-bold text-slate-700">Opsi
                    {{ strtoupper($o) }}</label>
                <input type="text" name="opsi_{{ $o }}" id="opsi_{{ $o }}"
                    value="{{ old('opsi_' . $o, $s?->{'opsi_' . $o}) }}" required
                    class="block w-full p-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500">
                @error('opsi_' . $o)
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="jawaban_benar" class="block mb-2 text-sm font-bold text-slate-700">Jawaban Benar</label>
            <select name="jawaban_benar" id="jawaban_benar"
                class="block w-full p-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-green-500">
                @foreach (['a', 'b', 'c', 'd'] as $o)
                    <option value="{{ $o }}" @selected(old('jawaban_benar', $s?->jawaban_benar) === $o)>{{ strtoupper($o) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="poin" class="block mb-2 text-sm font-bold text-slate-700">Poin</label>
            <input type="number" name="poin" id="poin" min="1" max="100"
                value="{{ old('poin', $s?->poin ?? 10) }}" required
                class="block w-full p-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:ring-cyan-500">
        </div>
    </div>
</div>

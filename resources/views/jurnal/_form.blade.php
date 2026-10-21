@php($j = $jurnal ?? null)

<div class="mb-5">
    <label for="ringkasan" class="block text-sm font-medium text-slate-700 mb-1">Ringkasan</label>
    <textarea name="ringkasan" id="ringkasan" rows="5"
        placeholder="Tulis ringkasan dengan kata-katamu sendiri (minimal 20 karakter)"
        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary">{{ old('ringkasan', $j?->ringkasan) }}</textarea>
    @error('ringkasan')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div>
        <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
        <select name="status" id="status"
            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary">
            <option value="sedang_dibaca" @selected(old('status', $j?->status ?? 'sedang_dibaca') === 'sedang_dibaca')>
                Sedang dibaca</option>
            <option value="selesai" @selected(old('status', $j?->status) === 'selesai')>Selesai</option>
        </select>
        @error('status')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="rating" class="block text-sm font-medium text-slate-700 mb-1">Rating (1-5)</label>
        <input type="number" name="rating" id="rating" min="1" max="5" value="{{ old('rating', $j?->rating) }}"
            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary">
        @error('rating')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
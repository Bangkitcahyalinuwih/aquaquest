<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Edit Target Belajar</h1>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-1">Edit Target Belajar</h2>
            <p class="text-slate-500 text-sm mb-6">Perbarui status atau detail dari target belajarmu.</p>

            <form action="{{ route('targets.update', $target->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Input Judul Target --}}
                <div>
                    <label for="judul_target" class="block text-sm font-semibold text-slate-700 mb-2">Judul Target</label>
                    <input type="text" id="judul_target" name="judul_target" value="{{ old('judul_target', $target->judul_target) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm">
                    @error('judul_target')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Select Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-2">Kategori Target</label>
                    <select id="kategori" name="kategori" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm bg-white">
                        <option value="Kuis" {{ old('kategori', $target->kategori) == 'Kuis' ? 'selected' : '' }}>Kuis</option>
                        <option value="Ensiklopedia" {{ old('kategori', $target->kategori) == 'Ensiklopedia' ? 'selected' : '' }}>Ensiklopedia</option>
                        <option value="Materi Edukasi" {{ old('kategori', $target->kategori) == 'Materi Edukasi' ? 'selected' : '' }}>Materi Edukasi</option>
                    </select>
                    @error('kategori')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Select Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status Capaian</label>
                    <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm bg-white">
                        <option value="Belum Selesai" {{ old('status', $target->status) == 'Belum Selesai' ? 'selected' : '' }}>⏳ Belum Selesai</option>
                        <option value="Selesai" {{ old('status', $target->status) == 'Selesai' ? 'selected' : '' }}>✔ Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi Target --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Target</label>
                    <textarea 
                        name="deskripsi" 
                        id="deskripsi" 
                        rows="3" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm"
                        placeholder="Catatan tambahan target..."
                    >{{ old('deskripsi', $target->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('targets.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-cyan-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-md transition-all">
                        Perbarui Target
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
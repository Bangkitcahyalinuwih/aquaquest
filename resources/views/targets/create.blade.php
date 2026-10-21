<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Tambah Target Belajar</h1>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-1">Buat Target Belajar Baru</h2>
            <p class="text-slate-500 text-sm mb-6">Pilih kategori dan judul materi yang ingin kamu jadikan target belajar.</p>

            <form action="{{ route('targets.store') }}" method="POST" class="space-y-5" x-data="{ kategori: '{{ old('kategori') }}' }">
                @csrf

                {{-- Pilih Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-2">Pilih Kategori Target</label>
                    <select id="kategori" name="kategori" x-model="kategori" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Kuis">Kuis</option>
                        <option value="Ensiklopedia">Ensiklopedia</option>
                        <option value="Materi Edukasi">Materi Edukasi</option>
                    </select>
                    @error('kategori')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dropdown Judul Ensiklopedia --}}
                <div x-show="kategori === 'Ensiklopedia'" x-cloak class="space-y-1">
                    <label for="biota_id" class="block text-sm font-semibold text-slate-700 mb-2">Pilih Judul Ensiklopedia / Biota</label>
                    <select id="biota_id" name="biota_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm bg-white">
                        <option value="">-- Pilih Biota Laut --</option>
                        @foreach ($biotas as $biota)
                            <option value="{{ $biota->id }}">
                                {{ $biota->nama_biota ?? $biota->nama ?? 'Biota #'.$biota->id }}
                            </option>
                        @endforeach
                    </select>
                    @error('biota_id')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dropdown Judul Materi Edukasi --}}
                <div x-show="kategori === 'Materi Edukasi'" x-cloak class="space-y-1">
                    <label for="edukasi_id" class="block text-sm font-semibold text-slate-700 mb-2">Pilih Judul Materi Edukasi</label>
                    <select id="edukasi_id" name="edukasi_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm bg-white">
                        <option value="">-- Pilih Materi Edukasi --</option>
                        @foreach ($edukasis as $edukasi)
                            <option value="{{ $edukasi->id }}">
                                {{ $edukasi->judul ?? $edukasi->judul_materi ?? 'Materi #'.$edukasi->id }}
                            </option>
                        @endforeach
                    </select>
                    @error('edukasi_id')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                
                <textarea name="deskripsi" class="w-full rounded-md border-slate-300" placeholder="Deskripsi target (opsional)"></textarea>
                
                {{-- Pilihan Kuis --}}
                <div x-show="kategori === 'Kuis'" x-cloak class="p-4 bg-cyan-50 rounded-xl border border-cyan-100 text-xs text-cyan-800">
                    💡 Langsung Simpan
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('targets.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Kembali</a>
                    <button type="submit" class="bg-primary hover:bg-cyan-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-md transition-all">
                        Simpan Target
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
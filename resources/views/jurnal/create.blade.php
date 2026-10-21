<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h1 class="text-2xl font-bold text-primary mb-1">Tambah jurnal</h1>
            <p class="text-sm text-slate-500 mb-6">Catat apa yang kamu pelajari dari artikel edukasi.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    Ada {{ $errors->count() }} kesalahan, periksa form di bawah.
                </div>
            @endif

            @if ($daftarArtikel->isEmpty())
                <p class="text-slate-600">Semua artikel sudah kamu jurnalkan.</p>
            @else
                <form action="{{ route('jurnal.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="konten_edukasi_id" class="block text-sm font-medium text-slate-700 mb-1">Artikel</label>
                        <select name="konten_edukasi_id" id="konten_edukasi_id"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="">-- pilih artikel --</option>
                            @foreach ($daftarArtikel as $artikel)
                                <option value="{{ $artikel->id }}" @selected(old('konten_edukasi_id') == $artikel->id)>
                                    {{ $artikel->judul }}</option>
                            @endforeach
                        </select>
                        @error('konten_edukasi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    @include('jurnal._form')

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-md hover:bg-cyan-800">Simpan</button>
                        <a href="{{ route('jurnal.index') }}" class="text-sm text-slate-600 hover:text-primary">Batal</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
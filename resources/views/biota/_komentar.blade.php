<section id="komentar" class="mt-10">
    <h2 class="text-xl font-semibold text-primary">Komentar ({{ $komentar->total() }})</h2>

    @if (session('komentar_status'))
        <div class="mt-3 rounded-md border border-green-300 bg-green-50 text-green-800 px-4 py-3 text-sm">
            {{ session('komentar_status') }}
        </div>
    @endif

    {{-- Form tambah (hanya untuk yang login) --}}
    @auth
        <form method="POST" action="{{ route('komentar.store', $biota) }}" class="mt-4">
            @csrf

            {{-- Input Rating --}}
            <div class="mb-3">
                <label for="rating" class="block text-sm font-medium text-slate-700 mb-1">Beri Rating (1-5)</label>
                <input type="number" name="rating" id="rating" min="1" max="5" required
                    value="{{ old('rating') }}"
                    class="w-24 border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('rating')" class="mt-1" />
            </div>

            {{-- Input Isi Komentar --}}
            <textarea name="isi" rows="3" required maxlength="1000" placeholder="Tulis komentarmu..."
                class="w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">{{ old('isi') }}</textarea>
            <x-input-error :messages="$errors->get('isi')" class="mt-1" />

            <x-primary-button class="mt-2">Kirim Komentar</x-primary-button>
        </form>
    @else
        <p class="mt-4 text-sm text-slate-600">
            <a href="{{ route('komentar.login', $biota) }}" class="text-primary underline">Masuk untuk berkomentar</a>
        </p>
    @endauth

    {{-- Daftar komentar --}}
    <div class="mt-6 space-y-4">
        @forelse ($komentar as $item)
            <article class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-semibold text-slate-800">{{ $item->user->name }}</span>
                    <span class="text-slate-500">
                        {{ $item->created_at->diffForHumans() }}
                        @if ($item->updated_at->gt($item->created_at))
                            (diedit)
                        @endif
                    </span>
                </div>

                {{-- Menampilkan Nilai Rating --}}
                @if ($item->rating)
                    <div class="mt-1 text-sm font-bold text-yellow-500">
                        Rating: {{ $item->rating }} / 5 ⭐
                    </div>
                @endif

                {{-- {{ }} meng-escape HTML sehingga aman dari XSS --}}
                <p class="mt-2 text-slate-700 whitespace-pre-line">{{ $item->isi }}</p>

                <div class="mt-3 flex gap-4 text-sm">
                    @can('update', $item)
                        <a href="{{ route('komentar.edit', $item) }}" class="text-primary hover:underline">Ubah</a>
                    @endcan
                    @can('delete', $item)
                        <form method="POST" action="{{ route('komentar.destroy', $item) }}"
                            onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    @endcan
                </div>
            </article>
        @empty
            <p class="text-slate-500">Belum ada komentar. Jadilah yang pertama!</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $komentar->fragment('komentar')->links() }}</div>
</section>

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Ubah Komentar</h1>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 px-4 sm:px-6">
        <form method="POST" action="{{ route('komentar.update', $komentar) }}"
            class="bg-white shadow rounded-lg p-6 space-y-4">
            @csrf
            @method('PUT')

            <p class="text-sm text-slate-500">Biota: <strong>{{ $komentar->biota->nama }}</strong></p>

            <textarea name="isi" rows="5" required maxlength="1000"
                class="w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">{{ old('isi', $komentar->isi) }}</textarea>
            <x-input-error :messages="$errors->get('isi')" class="mt-1" />

            <div class="flex items-center gap-3">
                <x-primary-button>Simpan Perubahan</x-primary-button>
                <a href="{{ route('biota.show', $komentar->biota) }}#komentar"
                    class="text-sm text-slate-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>

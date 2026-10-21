<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h1 class="text-2xl font-bold text-primary mb-1">Ubah jurnal</h1>
            <p class="text-sm text-slate-500 mb-6">{{ $jurnal->kontenEdukasi->judul }}</p>

            @if ($errors->any())
                <div class="mb-5 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    Ada {{ $errors->count() }} kesalahan, periksa form di bawah.
                </div>
            @endif

            <form action="{{ route('jurnal.update', $jurnal) }}" method="POST">
                @csrf
                @method('PUT')

                @include('jurnal._form')

                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-md hover:bg-cyan-800">Perbarui</button>
                    <a href="{{ route('jurnal.index') }}" class="text-sm text-slate-600 hover:text-primary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
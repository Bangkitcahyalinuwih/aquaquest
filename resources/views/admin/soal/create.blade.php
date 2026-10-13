<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="mb-6 max-w-4xl mx-auto">
                <h1 class="text-2xl font-extrabold text-cyan-800">Tambah Soal Kuis</h1>
                <p class="text-slate-500 text-sm mt-1">Buat pertanyaan baru untuk diuji kepada pemain.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-cyan-100 max-w-4xl mx-auto">
                <form action="{{ route('admin.soal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @include('admin.soal._form')

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-semibold rounded-xl text-sm px-8 py-3 text-center shadow-md hover:shadow-lg transition-all duration-200">
                            Simpan Soal
                        </button>
                        <a href="{{ route('admin.soal.index') }}"
                            class="text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-100 font-semibold rounded-xl text-sm px-8 py-3 text-center shadow-sm hover:shadow-md transition-all duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>

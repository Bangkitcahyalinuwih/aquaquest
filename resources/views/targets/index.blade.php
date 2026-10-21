<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Target Belajar Saya</h1>
    </x-slot>

    {{-- x-data Alpine.js ditaruh di pembungkus utama --}}
    <div x-data="{ openDelete: false, targetId: null, targetJudul: '' }" class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">🎯 Daftar Target Belajar</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola dan pantau progres pembelajaran biota lautmu di AquaQuest.</p>
            </div>
            <a href="{{ route('targets.create') }}" 
               class="inline-flex items-center gap-2 bg-primary hover:bg-cyan-800 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Target Baru
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Card Grid Section --}}
        @if ($targets->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($targets as $target)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start gap-2 mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700 border border-cyan-100">
                                    {{ $target->kategori }}
                                </span>

                                @if ($target->status == 'Selesai')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 flex items-center gap-1">
                                        <span>✔</span> Selesai
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 flex items-center gap-1">
                                        <span>⏳</span> Proses
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-2 leading-snug">
                                {{ $target->judul_target }}
                            </h3>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-4 mt-4 border-t border-slate-100 flex justify-end gap-2">
                            <a href="{{ route('targets.edit', $target->id) }}" 
                               class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-primary hover:bg-slate-50 rounded-lg transition-colors">
                                Edit
                            </a>
                            
                            {{-- Tombol Hapus memicu Modal Alpine.js --}}
                            <button type="button" 
                                    @click="openDelete = true; targetId = {{ $target->id }}; targetJudul = '{{ addslashes($target->judul_target) }}'"
                                    class="px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-cyan-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    🌊
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Target Belajar</h3>
                <p class="text-slate-500 text-sm mb-6">Yuk, buat target pertamamu untuk menambah keseruan belajar di AquaQuest!</p>
                <a href="{{ route('targets.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-cyan-800 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all">
                    + Tambah Target Sekarang
                </a>
            </div>
        @endif

        {{-- Hidden Form untuk Eksekusi Hapus --}}
        <form id="global-delete-form" action="" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        {{-- Modal Popup Tailwind + Alpine.js --}}
        <div x-show="openDelete" 
             x-cloak
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
            <div @click.outside="openDelete = false" 
                 class="bg-white rounded-2xl max-w-sm w-full p-6 text-center shadow-xl border border-slate-100">
                <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                    ⚠️
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Konfirmasi Hapus</h3>
                <p class="text-slate-500 text-sm mb-6">
                    Yakin ingin menghapus target <span class="font-semibold text-slate-700" x-text="targetJudul"></span>?
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="openDelete = false" 
                            class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button @click="
                                const form = document.getElementById('global-delete-form');
                                form.action = '/targets/' + targetId;
                                form.submit();
                            "
                            class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition-colors shadow-sm">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
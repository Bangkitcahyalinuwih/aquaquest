<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-cyan-100 rounded-lg text-cyan-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Admin</h1>
                <p class="text-sm text-slate-500 mt-0.5">Ringkasan aktivitas dan data ensiklopedia AquaQuest.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 space-y-6">
        
        <!-- TOP CARDS / STATISTIK -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $stats = [
                    ['Biota', $jumlahBiota, 'M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z', 'text-blue-600', 'bg-blue-50'],
                    ['Edukasi', $jumlahEdukasi, 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25', 'text-emerald-600', 'bg-emerald-50'],
                    ['Soal', $jumlahSoal, 'M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z', 'text-amber-500', 'bg-amber-50'],
                    ['Kartu', $jumlahKartu, 'M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9', 'text-purple-600', 'bg-purple-50'],
                    ['Pemain', $jumlahPemain, 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z', 'text-indigo-600', 'bg-indigo-50'],
                    ['Kuis Selesai', $sesiSelesai, 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'text-cyan-600', 'bg-cyan-50']
                ];
            @endphp

            @foreach ($stats as [$label, $angka, $icon, $textColor, $bgColor])
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 py-4 px-3 flex flex-col items-center justify-center transition-all hover:shadow-md hover:-translate-y-1">
                    <div class="w-8 h-8 rounded-full {{ $bgColor }} {{ $textColor }} flex items-center justify-center mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                    </div>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $angka }}</p>
                    <p class="text-[11px] font-semibold text-slate-500 mt-1 uppercase tracking-wider">{{ $label }}</p>
                </div>
            @endforeach
        </div>

        <!-- MAIN GRIDS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- LEADERBOARD / PEMAIN TERATAS -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        Pemain Teratas
                    </h2>
                </div>
                
                <div class="p-5 flex-grow">
                    @forelse ($pemainTeratas as $i => $p)
                        <div class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-0 last:pb-0 {{ $i === 0 ? 'pt-0' : '' }}">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold text-sm">
                                    {{ substr($p->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm flex items-center gap-2">
                                        {{ $p->name }}
                                        @if($i === 0) 
                                            <span class="text-xs bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded text-[10px]">#1</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Level {{ $p->level }}
                                </span>
                                <p class="text-[11px] text-slate-500 font-medium mt-1">{{ number_format($p->total_xp) }} XP</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum ada pemain</h3>
                            <p class="mt-1 text-xs text-slate-500">Daftar pemain dengan level tertinggi akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SESI KUIS TERBARU -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Aktivitas Kuis Terbaru
                    </h2>
                </div>

                <div class="p-5 flex-grow">
                    @forelse ($sesiTerbaru as $i => $s)
                        <div class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-0 last:pb-0 {{ $i === 0 ? 'pt-0' : '' }}">
                            <div>
                                <p class="font-medium text-slate-800 text-sm">{{ $s->user->name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $s->selesai_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex gap-0.5">
                                    @for($j = 1; $j <= 5; $j++)
                                        <div class="w-1.5 h-3.5 rounded-sm {{ $j <= $s->jumlah_benar ? 'bg-emerald-400' : 'bg-slate-200' }}"></div>
                                    @endfor
                                </div>
                                <span class="text-[11px] font-bold {{ $s->jumlah_benar >= 3 ? 'text-emerald-600' : 'text-slate-500' }} ml-1">
                                    {{ $s->jumlah_benar }}/5
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum ada aktivitas</h3>
                            <p class="mt-1 text-xs text-slate-500">Sesi kuis yang diselesaikan oleh user akan tampil di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS / TOMBOL CEPAT -->
        <div class="pt-2 border-t border-slate-200">
            <h3 class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wider">Aksi Cepat</h3>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('admin.biota.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Data Biota
                </a>
                
                <a href="{{ route('admin.edukasi.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Materi Edukasi
                </a>
                
                @if (Route::has('admin.soal.create'))
                    <a href="{{ route('admin.soal.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Soal Kuis
                    </a>
                @endif
                
                @if (Route::has('admin.kartu.create'))
                    <a href="{{ route('admin.kartu.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Kartu Koleksi
                    </a>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
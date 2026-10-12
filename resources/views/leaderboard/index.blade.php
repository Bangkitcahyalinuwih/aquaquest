<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Peringkat</h1>
    </x-slot>
    @php
        $daftar = collect(
            $pemain instanceof \Illuminate\Pagination\AbstractPaginator ? $pemain->items() : $pemain,
        )->values();
        $podium = $daftar->take(3);
        $lainnya = $daftar->slice(3);
        $maks = max(1, (int) $daftar->max('total_xp'));
        $urutPodium = [0 => 'order-2', 1 => 'order-1', 2 => 'order-3'];
        $tinggiBar = [0 => 'h-44', 1 => 'h-32', 2 => 'h-24'];
        $warnaBar = [
            0 => 'bg-gradient-to-t from-primary to-secondary',
            1 => 'bg-gradient-to-t from-secondary to-accent',
            2 => 'bg-gradient-to-t from-secondary/70 to-accent/80',
        ];
        $medali = ['🥇', '🥈', '🥉'];
    @endphp
   <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        @if ($daftar->isEmpty())
            <div class="bg-white rounded-lg border border-slate-200 p-8 text-center">
                <p class="text-base font-medium text-slate-700">Belum ada data peringkat</p>
                <p class="text-xs text-slate-500 mt-1">Selesaikan kuis untuk mulai mengumpulkan poin.</p>
                <a href="{{ route('kuis.index') }}"
                    class="mt-4 inline-block rounded-md bg-[#0E7490] px-4 py-2 text-xs font-semibold text-white hover:bg-cyan-800 transition">
                    Mulai Kuis
                </a>
            </div>
        @else
            {{-- Top 3 Podium Minimalis --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6 mb-6">
                <div class="flex items-end justify-center gap-4 sm:gap-8 pt-2">
                    @foreach ($podium as $i => $item)
                        @php $saya = auth()->id() === ($item->id ?? null); @endphp
                        <div class="{{ $urutPodium[$i] }} flex-1 max-w-[9rem] text-center">
                            
                            <div class="mb-2">
                                {{-- Medali --}}
                                <span class="text-2xl block mb-1" aria-hidden="true">{{ $medali[$i] }}</span>
                                
                                <p class="font-semibold text-slate-800 text-xs sm:text-sm truncate" title="{{ $item->name }}">{{ $item->name }}</p>
                                @if ($saya)
                                    <span class="inline-block rounded bg-teal-50 text-[#0E7490] border border-teal-200 px-1.5 py-0.5 text-[10px] font-medium">Kamu</span>
                                @endif
                                <p class="text-xs font-bold text-[#0E7490] mt-0.5 tabular-nums">{{ number_format($item->total_xp) }} XP</p>
                            </div>

                            <div class="{{ $tinggiBar[$i] }} {{ $i === 0 ? 'bg-[#0E7490]' : 'bg-slate-100 border-t border-x border-slate-200' }} rounded-t flex items-center justify-center">
                                <span class="text-lg font-bold {{ $i === 0 ? 'text-white' : 'text-slate-400' }}">{{ $i + 1 }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tabel Peringkat --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase">
                        <tr>
                            <th class="px-4 py-3 w-12 text-center">#</th>
                            <th class="px-4 py-3">Nama Pemain</th>
                            <th class="px-4 py-3 text-center">Level</th>
                            <th class="px-4 py-3 text-right">Total XP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($daftar as $index => $item)
                            @php $saya = auth()->id() === ($item->id ?? null); @endphp
                            <tr class="{{ $saya ? 'bg-teal-50/50' : 'hover:bg-slate-50' }} transition-colors">
                                <td class="px-4 py-3 text-center font-semibold {{ $index < 3 ? 'text-[#0E7490]' : 'text-slate-400' }}">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800">
                                    {{ $item->name }}
                                    @if ($saya)
                                        <span class="ml-1.5 rounded bg-teal-100 text-[#0E7490] px-1.5 py-0.5 text-[10px] font-semibold">Kamu</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-xs text-slate-500">
                                    Level {{ $item->level }}
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-slate-700 tabular-nums">
                                    {{ number_format($item->total_xp) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-app-layout>

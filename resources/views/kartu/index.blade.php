<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-primary">Koleksi Kartu</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6">
        <p class="text-slate-600 mb-6">
            Kamu memiliki <strong>{{ count($dimiliki) }}</strong> dari <strong>{{ $kartu->count() }}</strong> kartu.
            Total XP: <strong>{{ $totalXp }}</strong>
        </p>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach ($kartu as $item)
                @php $terbuka = in_array($item->id, $dimiliki); @endphp

                <div class="bg-white rounded-lg shadow overflow-hidden text-center {{ $terbuka ? '' : 'opacity-60' }}">
                    <div class="h-36 flex items-center justify-center relative" style="background:#CFFAFE">
                       
                        @if ($item->gambar_url)
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}" class="h-full w-full object-cover {{ $terbuka ? '' : 'blur-sm filter brightness-75' }}">
                        @else
                            <span class="text-5xl" aria-hidden="true">🐢</span>
                        @endif

                        @if (!$terbuka)
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                <span class="text-4xl drop-shadow-md" aria-hidden="true">🔒</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-semibold text-sm {{ $terbuka ? 'text-primary' : 'text-slate-400' }}">
                            {{ $terbuka ? $item->nama : 'Kartu Terkunci' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            @if ($terbuka)
                                {{ $item->biota->nama }}
                            @else
                                Butuh {{ $item->xp_syarat }} XP (kurang {{ max(0, $item->xp_syarat - $totalXp) }})
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
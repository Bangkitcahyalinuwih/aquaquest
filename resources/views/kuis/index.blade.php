<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4" x-data="kuisApp()" x-init="mulai()">

        {{-- Status: memuat --}}
        <template x-if="status === 'memuat'">
            <div class="text-center py-12">
                <p class="text-slate-500 font-medium">Memuat soal kuis...</p>
            </div>
        </template>

        {{-- Status: sedang mengerjakan kuis --}}
        <template x-if="status === 'berjalan'">
            <div class="bg-white rounded-2xl shadow-sm border border-cyan-100 p-6">
                <!-- Header Kuis (Info Soal & Timer) -->
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                    <span
                        class="text-sm font-medium text-slate-600 bg-slate-50 px-3 py-1 rounded-full border border-slate-200">
                        Soal <span x-text="indexSoal + 1"></span> dari <span x-text="soal.length"></span>
                    </span>

                    <span class="font-mono font-bold flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 border"
                        :class="sisaDetik <= 10 ? 'text-red-600 border-red-200 bg-red-50' : 'text-cyan-700 border-cyan-200'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span x-text="sisaDetik"></span> detik
                    </span>
                </div>

                <!-- Pertanyaan -->
                <h2 class="text-xl font-bold text-slate-800 mb-6 leading-relaxed" x-text="soalSekarang.pertanyaan"></h2>

                <!-- Pilihan Jawaban -->
                <div class="grid grid-cols-1 gap-3">
                    <template x-for="opsi in ['a', 'b', 'c', 'd']" :key="opsi">
                        <button @click="jawabSoal(opsi)" :disabled="terkunci"
                            class="text-left border rounded-xl p-4 transition-all duration-200 font-medium disabled:cursor-not-allowed hover:shadow-sm"
                            :class="kelasOpsi(opsi)">
                            <span class="inline-block w-6 font-bold" x-text="opsi.toUpperCase() + '.'"></span>
                            <span x-text="soalSekarang['opsi_' + opsi]"></span>
                        </button>
                    </template>
                </div>
            </div>
        </template>

        {{-- Status: kuis selesai --}}
        <template x-if="status === 'selesai'">
            <div class="bg-white rounded-2xl shadow-sm border border-cyan-100 p-8 text-center">
                <div
                    class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-slate-800 mb-2">Kuis Selesai!</h2>

                <div class="bg-slate-50 rounded-xl p-6 my-6 border border-slate-100 space-y-3">
                    <p class="text-lg">Jawaban benar: <strong class="text-emerald-600"><span
                                x-text="hasilAkhir.jumlah_benar"></span> dari 5</strong></p>
                    <p class="text-slate-600">XP didapat: <strong class="text-cyan-700">+<span
                                x-text="hasilAkhir.xp_didapat"></span> XP</strong></p>

                    <template x-if="hasilAkhir.sudah_main_hari_ini">
                        <p class="text-sm text-amber-600 bg-amber-50 rounded-lg p-2 mt-2 border border-amber-200">
                            (XP tidak bertambah — kamu sudah bermain hari ini)
                        </p>
                    </template>

                    <p class="text-slate-600 pt-2 border-t border-slate-200 mt-2">Level kamu sekarang: <strong
                            class="text-indigo-600">Level <span x-text="hasilAkhir.level"></span></strong></p>
                </div>

                <template x-if="hasilAkhir.kartu_baru && hasilAkhir.kartu_baru.length > 0">
                    <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-xl">
                        <p class="text-purple-700 font-bold mb-1">🎉 Hore! Kartu baru terbuka:</p>
                        <p class="text-purple-900 font-medium" x-text="hasilAkhir.kartu_baru.join(', ')"></p>
                    </div>
                </template>

                <a href="{{ route('kuis.index') }}"
                    class="inline-block bg-cyan-600 hover:bg-cyan-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                    Main Lagi
                </a>
            </div>
        </template>

        {{-- Status: waktu habis --}}
        <template x-if="status === 'habis_waktu'">
            <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-8 text-center">
                <div
                    class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Waktu Habis!</h2>
                <p class="text-slate-500 mb-6">Sayang sekali, kamu kehabisan waktu untuk menjawab soal ini.</p>
                <a href="{{ route('kuis.index') }}"
                    class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                    Coba Lagi
                </a>
            </div>
        </template>
    </div>

    @push('scripts')
        <script>
            function kuisApp() {
                return {
                    status: 'memuat',
                    gameId: null,
                    deadlineAt: null,
                    soal: [],
                    indexSoal: 0,
                    sisaDetik: 0,
                    terkunci: false,
                    jawabanTerpilih: null,
                    jawabanBenarTerakhir: null,
                    hasilAkhir: null,
                    timer: null,

                    get soalSekarang() {
                        return this.soal[this.indexSoal] ?? {};
                    },

                    csrfToken() {
                        return document.querySelector('meta[name="csrf-token"]').content;
                    },

                    async mulai() {
                        try {
                            const res = await fetch('{{ route('kuis.mulai') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Accept': 'application/json'
                                },
                            });

                            if (!res.ok) throw new Error('Gagal memulai kuis');

                            const data = await res.json();
                            this.gameId = data.game_id;
                            this.deadlineAt = new Date(data.deadline_at);
                            this.soal = data.soal;
                            this.status = 'berjalan';
                            this.jalankanTimer();
                        } catch (error) {
                            console.error(error);
                            alert('Terjadi kesalahan saat memuat kuis. Pastikan kamu sudah login.');
                        }
                    },

                    jalankanTimer() {
                        this.timer = setInterval(() => {
                            const sisaMs = this.deadlineAt - new Date();
                            this.sisaDetik = Math.max(0, Math.floor(sisaMs / 1000));

                            if (this.sisaDetik <= 0) {
                                clearInterval(this.timer);
                                this.status = 'habis_waktu';
                            }
                        }, 1000);
                    },

                    kelasOpsi(opsi) {
                        if (this.jawabanTerpilih !== opsi) {
                            return !this.terkunci ? 'border-slate-300 bg-white hover:border-cyan-400 hover:bg-cyan-50' :
                                'border-slate-200 bg-slate-50 text-slate-400';
                        }

                        return opsi === this.jawabanBenarTerakhir ?
                            'border-emerald-500 bg-emerald-50 text-emerald-700 ring-2 ring-emerald-200' :
                            'border-red-500 bg-red-50 text-red-700 ring-2 ring-red-200';
                    },

                    async jawabSoal(opsi) {
                        if (this.terkunci) return;
                        this.terkunci = true;
                        this.jawabanTerpilih = opsi;

                        try {
                            const res = await fetch(`/kuis/${this.gameId}/jawab`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    soal_id: this.soalSekarang.id,
                                    pilihan: opsi
                                }),
                            });

                            if (!res.ok) throw new Error('Gagal mengirim jawaban');

                            const data = await res.json();
                            this.jawabanBenarTerakhir = data.jawaban_benar;

                            setTimeout(() => this.soalBerikutnya(), 1200);
                        } catch (error) {
                            console.error(error);
                            this.terkunci = false;
                            alert('Gagal mengirim jawaban. Coba lagi.');
                        }
                    },

                    async soalBerikutnya() {
                        this.terkunci = false;
                        this.jawabanTerpilih = null;
                        this.jawabanBenarTerakhir = null;

                        if (this.indexSoal + 1 < this.soal.length) {
                            this.indexSoal++;
                            return;
                        }

                        clearInterval(this.timer);
                        try {
                            const res = await fetch(`/kuis/${this.gameId}/selesai`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Accept': 'application/json'
                                },
                            });

                            if (!res.ok) throw new Error('Gagal memproses hasil kuis');

                            this.hasilAkhir = await res.json();
                            this.status = 'selesai';
                        } catch (error) {
                            console.error(error);
                            alert('Gagal memproses hasil akhir.');
                        }
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>

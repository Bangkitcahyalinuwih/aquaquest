<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6" x-data="kuisApp()" x-init="mulai()">

        <!-- KONTENER UTAMA KUIS -->
        <div class="bg-white rounded-3xl shadow-xl shadow-cyan-900/5 border border-slate-100 overflow-hidden relative">

            <!-- STATE 1: MEMUAT -->
            <template x-if="status === 'memuat'">
                <div class="flex flex-col items-center justify-center py-24">
                    <svg class="animate-spin h-10 w-10 text-cyan-500 mb-4" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <p class="text-lg font-medium text-slate-500 animate-pulse">Mempersiapkan soal kuis...</p>
                </div>
            </template>

            <!-- STATE 2: GAGAL -->
            <template x-if="status === 'gagal'">
                <div class="text-center py-20 px-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-lg text-slate-800 font-bold mb-2" x-text="pesanError"></p>
                    <p class="text-slate-500 text-sm mb-6">Terjadi kendala saat memuat kuis.</p>
                    <a href="{{ route('home') }}"
                        class="inline-block px-6 py-2.5 bg-slate-900 text-white rounded-xl font-medium hover:bg-slate-800 transition">Kembali
                        ke Beranda</a>
                </div>
            </template>

            <!-- STATE 3: KUIS BERJALAN -->
            <template x-if="status === 'berjalan'">
                <div class="p-6 sm:p-8 md:p-10">
                    <!-- Header Kuis: Indikator Soal & Timer -->
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pertanyaan</p>
                            <p class="text-xl font-black text-slate-800">
                                <span x-text="indexSoal + 1" class="text-cyan-600"></span>
                                <span class="text-slate-400 mx-1">/</span>
                                <span x-text="soal.length"></span>
                            </p>
                        </div>

                        <!-- Timer Animasi -->
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl font-mono font-bold text-lg transition-colors duration-300 shadow-sm border"
                            :class="sisaDetik <= 10 ? 'bg-red-50 text-red-600 border-red-200 animate-pulse' :
                                'bg-white text-slate-700 border-slate-200'">
                            <svg class="w-5 h-5" :class="sisaDetik <= 10 ? 'text-red-500' : 'text-slate-400'"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span x-text="format(sisaDetik)"></span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-100 rounded-full h-2.5 mb-8 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-cyan-400 to-cyan-600 h-2.5 rounded-full transition-all duration-500 ease-out"
                            :style="`width: ${((indexSoal) / soal.length) * 100}%`"></div>
                    </div>

                    <!-- Gambar Soal (Jika Tipe Gambar) -->
                    <template x-if="soalSekarang.tipe === 'gambar' && soalSekarang.gambar">
                        <div class="mb-6 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 p-2 shadow-sm">
                            <img :src="'/storage/' + soalSekarang.gambar" alt="Gambar soal"
                                class="w-full max-h-64 object-contain rounded-xl">
                        </div>
                    </template>

                    <!-- Teks Pertanyaan -->
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-8 leading-snug"
                        x-text="soalSekarang.pertanyaan"></h2>

                    <!-- Pilihan Ganda -->
                    <div class="grid grid-cols-1 gap-3 sm:gap-4">
                        <template x-for="opsi in ['a', 'b', 'c', 'd']" :key="opsi">
                            <button @click="jawabSoal(opsi)" :disabled="terkunci"
                                class="w-full text-left border-2 rounded-2xl p-4 transition-all duration-200 flex items-center gap-4 group"
                                :class="kelasOpsi(opsi)">

                                <!-- Abjad Opsi (A, B, C, D) -->
                                <span
                                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-sm font-bold border border-slate-200 group-hover:border-cyan-300 transition-colors"
                                    :class="(jawabanTerpilih === opsi && opsi !== jawabanBenarTerakhir) ?
                                    'text-red-500 border-red-300' : (opsi === jawabanBenarTerakhir ?
                                        'text-emerald-600 border-emerald-300' : 'text-slate-600')"
                                    x-text="opsi.toUpperCase()"></span>

                                <!-- Teks Jawaban -->
                                <span class="font-medium text-[15px] sm:text-base leading-tight"
                                    x-text="soalSekarang['opsi_' + opsi]"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Pesan Error (Muncul jika ada masalah server saat submit jawaban) -->
                    <p x-show="pesanError" x-transition x-text="pesanError"
                        class="mt-4 p-3 bg-red-50 border border-red-200 text-sm text-red-600 rounded-lg text-center"
                        style="display:none"></p>
                </div>
            </template>

            <!-- STATE 4: SELESAI -->
            <template x-if="status === 'selesai'">
                <div class="p-8 sm:p-10 text-center">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-cyan-100 mb-4 shadow-inner">
                        <span class="text-4xl">🏆</span>
                    </div>
                    <h2
                        class="text-2xl sm:text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-blue-600 mb-2">
                        Kuis Selesai!</h2>
                    <p class="text-slate-500 font-medium mb-6">Kerja bagus! Berikut adalah hasil akhirmu.</p>

                    <!-- Grid Statistik -->
                    <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto mb-6">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Skor Benar</p>
                            <p class="text-2xl font-black text-slate-800"><span
                                    x-text="hasilAkhir.jumlah_benar"></span><span
                                    class="text-slate-400 text-lg mx-1">/</span><span class="text-lg text-slate-500"
                                    x-text="soal.length"></span></p>
                        </div>
                        <div class="bg-cyan-50 p-4 rounded-2xl border border-cyan-100">
                            <p class="text-xs font-bold text-cyan-600 uppercase tracking-wider mb-1">XP Didapat</p>
                            <p class="text-2xl font-black text-cyan-800" x-text="'+' + hasilAkhir.xp_didapat"></p>
                        </div>
                    </div>

                    <p class="text-slate-700 font-medium mb-1">Level Sekarang: <strong class="text-cyan-700 text-lg"
                            x-text="hasilAkhir.level"></strong></p>

                    <template x-if="hasilAkhir.sudah_main_hari_ini">
                        <div
                            class="bg-amber-50 border border-amber-200 text-amber-700 text-xs p-3 rounded-lg max-w-sm mx-auto mb-4">
                            Kamu sudah mendapat XP hari ini. Sesi ini hanya dihitung sebagai latihan.
                        </div>
                    </template>

                    <template x-if="hasilAkhir.kartu_baru && hasilAkhir.kartu_baru.length > 0">
                        <div
                            class="mt-4 p-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white shadow-lg max-w-sm mx-auto">
                            <p class="text-xs font-bold text-indigo-100 uppercase tracking-wider mb-1">✨ Kartu Baru
                                Terbuka!</p>
                            <p class="font-semibold" x-text="hasilAkhir.kartu_baru.join(', ')"></p>
                        </div>
                    </template>

                    <!-- Tombol Navigasi Akhir -->
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('kuis.index') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all text-sm">Main
                            Lagi</a>
                        <a href="{{ route('kartu.index') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-cyan-500 text-cyan-700 font-semibold rounded-xl hover:bg-cyan-50 transition-all text-sm">Lihat
                            Koleksi</a>
                        <a href="{{ route('dashboard') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition-all text-sm">Dashboard</a>
                    </div>
                </div>
            </template>

            <!-- STATE 5: HABIS WAKTU -->
            <template x-if="status === 'habis_waktu'">
                <div class="text-center py-16 px-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-50 mb-4">
                        <span class="text-5xl">⏰</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-red-600 mb-2">Waktu Habis!</h2>
                    <p class="text-slate-600 font-medium mb-8 max-w-sm mx-auto">Sesi kuis ini tidak dihitung karena
                        waktu telah berakhir. Coba lagi dan jawab dengan lebih cepat!</p>
                    <a href="{{ route('kuis.index') }}"
                        class="inline-block px-8 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 shadow-md hover:shadow-lg hover:shadow-red-500/30 transition-all">Coba
                        Lagi</a>
                </div>
            </template>

        </div>
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
                    pesanError: '',
                    timer: null,

                    get soalSekarang() {
                        return this.soal[this.indexSoal] ?? {};
                    },

                    csrfToken() {
                        return document.querySelector('meta[name="csrf-token"]').content;
                    },

                    format(detik) {
                        const m = String(Math.floor(detik / 60)).padStart(2, '0');
                        const s = String(detik % 60).padStart(2, '0');
                        return `${m}:${s}`;
                    },

                    async panggil(url, body = null) {
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken(),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: body ? JSON.stringify(body) : null,
                        });

                        if (res.status === 401 || res.status === 419) {
                            window.location = '{{ route('login') }}';
                            throw new Error('Sesi login berakhir.');
                        }

                        const data = await res.json().catch(() => ({}));

                        if (!res.ok) {
                            const galat = new Error(data.message || 'Terjadi kesalahan. Coba lagi.');
                            galat.status = res.status;
                            throw galat;
                        }
                        return data;
                    },

                    async mulai() {
                        try {
                            const data = await this.panggil('{{ route('kuis.mulai') }}');
                            this.gameId = data.game_id;
                            this.deadlineAt = new Date(data.deadline_at);
                            this.soal = data.soal;
                            this.status = 'berjalan';
                            this.jalankanTimer();
                        } catch (e) {
                            this.pesanError = e.message;
                            this.status = 'gagal';
                        }
                    },

                    jalankanTimer() {
                        this.hitungSisa();
                        this.timer = setInterval(() => this.hitungSisa(), 1000);
                    },

                    hitungSisa() {
                        this.sisaDetik = Math.max(0, Math.floor((this.deadlineAt - new Date()) / 1000));
                        if (this.sisaDetik <= 0 && this.status === 'berjalan') {
                            clearInterval(this.timer);
                            this.status = 'habis_waktu';
                        }
                    },

                    // Pembaruan desain interaktif pada pilihan ganda
                    kelasOpsi(opsi) {
                        if (this.jawabanTerpilih === null) {
                            return 'border-slate-200 hover:border-cyan-400 hover:bg-cyan-50/50 hover:shadow-md text-slate-700 bg-white cursor-pointer';
                        }
                        if (opsi === this.jawabanBenarTerakhir) {
                            return 'border-emerald-500 bg-emerald-50 text-emerald-900 shadow-sm shadow-emerald-100 z-10 cursor-default';
                        }
                        if (opsi === this.jawabanTerpilih) {
                            return 'border-red-400 bg-red-50 text-red-900 shadow-sm shadow-red-100 z-10 cursor-default';
                        }
                        return 'border-slate-100 bg-slate-50 opacity-50 text-slate-400 cursor-default grayscale-[50%]';
                    },

                    async jawabSoal(opsi) {
                        if (this.terkunci) return;
                        this.terkunci = true;
                        this.pesanError = '';
                        this.jawabanTerpilih = opsi;

                        try {
                            const data = await this.panggil(`/kuis/${this.gameId}/jawab`, {
                                soal_id: this.soalSekarang.id,
                                pilihan: opsi,
                            });
                            this.jawabanBenarTerakhir = data.jawaban_benar;
                            setTimeout(() => this.soalBerikutnya(), 1500); // Diperpanjang sedikit agar animasi terbaca
                        } catch (e) {
                            clearInterval(this.timer);
                            if (/waktu/i.test(e.message)) {
                                this.status = 'habis_waktu';
                            } else {
                                this.pesanError = e.message;
                                this.terkunci = false;
                                this.jawabanTerpilih = null;
                            }
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
                            this.hasilAkhir = await this.panggil(`/kuis/${this.gameId}/selesai`);
                            this.status = 'selesai';
                        } catch (e) {
                            this.pesanError = e.message;
                            this.status = 'gagal';
                        }
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>

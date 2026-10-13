<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6" x-data="kuisApp()">

        <div class="bg-white rounded-3xl shadow-xl shadow-cyan-900/5 border border-slate-100 overflow-hidden relative">

            <!-- STATE 0: LAYAR AWAL -->
            <template x-if="status === 'awal'">
                <div class="p-8 sm:p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-cyan-100 mb-5 shadow-inner">
                        <svg class="w-10 h-10 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800">Siap menguji pengetahuanmu?</h1>
                    <p class="mt-2 text-slate-500">Jawab soal tentang biota perairan sebelum waktu habis.</p>

                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 text-left">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Jumlah soal</p>
                            <p class="mt-1 text-xl font-black text-slate-800" x-text="info.soal + ' soal'"></p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Waktu</p>
                            <p class="mt-1 text-xl font-black text-slate-800" x-text="info.menit + ' menit'"></p>
                        </div>
                        <div class="rounded-2xl border border-cyan-100 bg-cyan-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-cyan-600">XP</p>
                            <p class="mt-1 text-sm font-semibold text-cyan-800">Dihitung untuk kuis pertama tiap hari</p>
                        </div>
                    </div>

                    <ul class="mt-6 text-sm text-slate-500 text-left max-w-md mx-auto space-y-1 list-disc pl-5">
                        <li>Jawaban yang sudah dikirim tidak bisa diubah.</li>
                        <li>Kamu bisa berpindah antar soal lewat nomor di atas soal.</li>
                        <li>Soal yang tidak dijawab tidak mendapat poin.</li>
                    </ul>

                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <button type="button" @click="mulai()"
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all">
                            Mulai Kuis
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition-all text-sm">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </template>

            <!-- STATE 1: MEMUAT -->
            <template x-if="status === 'memuat'">
                <div class="flex flex-col items-center justify-center py-24">
                    <svg class="animate-spin h-10 w-10 text-cyan-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-lg font-medium text-slate-500 animate-pulse">Mempersiapkan soal kuis...</p>
                </div>
            </template>

            <!-- STATE 2: GAGAL -->
            <template x-if="status === 'gagal'">
                <div class="text-center py-20 px-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <p class="text-lg text-slate-800 font-bold mb-2" x-text="pesanError"></p>
                    <p class="text-slate-500 text-sm mb-6">Terjadi kendala saat memuat kuis.</p>
                    <a href="{{ route('home') }}"
                        class="inline-block px-6 py-2.5 bg-slate-900 text-white rounded-xl font-medium hover:bg-slate-800 transition">Kembali ke Beranda</a>
                </div>
            </template>

            <!-- STATE 3: KUIS BERJALAN -->
            <template x-if="status === 'berjalan'">
                <div class="p-6 sm:p-8 md:p-10">

                    <!-- Header: indikator soal + timer -->
                    <div class="flex justify-between items-end mb-5">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pertanyaan</p>
                            <p class="text-xl font-black text-slate-800">
                                <span x-text="indexSoal + 1" class="text-cyan-600"></span>
                                <span class="text-slate-400 mx-1">/</span>
                                <span x-text="soal.length"></span>
                                <span class="ml-2 text-xs font-semibold text-slate-400" x-text="'(' + jumlahDijawab + ' terjawab)'"></span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl font-mono font-bold text-lg transition-colors duration-300 shadow-sm border"
                            :class="sisaDetik <= 10 ? 'bg-red-50 text-red-600 border-red-200 animate-pulse' : 'bg-white text-slate-700 border-slate-200'">
                            <svg class="w-5 h-5" :class="sisaDetik <= 10 ? 'text-red-500' : 'text-slate-400'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span x-text="format(sisaDetik)"></span>
                        </div>
                    </div>

                    <!-- Progress: jumlah soal yang sudah dijawab -->
                    <div class="w-full bg-slate-100 rounded-full h-2.5 mb-5 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-cyan-400 to-cyan-600 h-2.5 rounded-full transition-all duration-500 ease-out"
                            :style="`width: ${(jumlahDijawab / soal.length) * 100}%`"></div>
                    </div>

                    <!-- Navigasi nomor soal -->
                    <div class="flex flex-wrap gap-2 mb-8">
                        <template x-for="(s, i) in soal" :key="s.id">
                            <button type="button" @click="pindah(i)" :class="kelasNomor(s, i)" x-text="i + 1"></button>
                        </template>
                    </div>

                    <!-- Gambar soal -->
                    <template x-if="soalSekarang.tipe === 'gambar' && soalSekarang.gambar">
                        <div class="mb-6 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 p-2 shadow-sm">
                            <img :src="'/storage/' + soalSekarang.gambar" alt="Gambar soal" class="w-full max-h-64 object-contain rounded-xl">
                        </div>
                    </template>

                    <!-- Pertanyaan -->
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-8 leading-snug" x-text="soalSekarang.pertanyaan"></h2>

                    <!-- Pilihan ganda -->
                    <div class="grid grid-cols-1 gap-3 sm:gap-4">
                        <template x-for="opsi in ['a', 'b', 'c', 'd']" :key="opsi">
                            <button @click="jawabSoal(opsi)" :disabled="terkunci || catatanSekarang !== null"
                                class="w-full text-left border-2 rounded-2xl p-4 transition-all duration-200 flex items-center gap-4 group"
                                :class="kelasOpsi(opsi)">
                                <span class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-sm font-bold border border-slate-200 group-hover:border-cyan-300 transition-colors"
                                    :class="kelasHuruf(opsi)" x-text="opsi.toUpperCase()"></span>
                                <span class="font-medium text-[15px] sm:text-base leading-tight" x-text="soalSekarang['opsi_' + opsi]"></span>
                            </button>
                        </template>
                    </div>

                    <p x-show="pesanError" x-transition x-text="pesanError"
                        class="mt-4 p-3 bg-red-50 border border-red-200 text-sm text-red-600 rounded-lg text-center" style="display:none"></p>

                    <!-- Konfirmasi selesai (kalau masih ada soal kosong) -->
                    <div x-show="konfirmasiSelesai" x-transition style="display:none"
                        class="mt-6 p-4 rounded-2xl border border-amber-200 bg-amber-50 text-sm text-amber-800">
                        <p class="font-semibold" x-text="'Masih ada ' + (soal.length - jumlahDijawab) + ' soal yang belum dijawab.'"></p>
                        <p class="mt-1">Soal yang kosong tidak mendapat poin. Selesaikan kuis sekarang?</p>
                        <div class="mt-3 flex gap-2">
                            <button type="button" @click="konfirmasiSelesai = false"
                                class="px-4 py-2 rounded-lg bg-white border border-amber-300 font-semibold">Lanjut menjawab</button>
                            <button type="button" @click="selesaiKuis()"
                                class="px-4 py-2 rounded-lg bg-amber-500 text-white font-semibold hover:bg-amber-600">Ya, selesai</button>
                        </div>
                    </div>

                    <!-- Tombol navigasi bawah -->
                    <div class="mt-8 flex items-center justify-between gap-3">
                        <button type="button" @click="sebelumnya()" :disabled="indexSoal === 0"
                            class="px-5 py-2.5 rounded-xl border-2 border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition disabled:opacity-40 disabled:cursor-not-allowed">
                            Sebelumnya
                        </button>

                        <template x-if="indexSoal < soal.length - 1">
                            <button type="button" @click="berikutnya()"
                                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-semibold text-sm hover:shadow-lg hover:shadow-cyan-500/30 transition">
                                Berikutnya
                            </button>
                        </template>
                        <template x-if="indexSoal === soal.length - 1">
                            <button type="button" @click="selesaiKuis()"
                                class="px-6 py-2.5 rounded-xl bg-emerald-500 text-white font-semibold text-sm hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 transition">
                                Selesai
                            </button>
                        </template>
                    </div>
                </div>
            </template>

            <!-- STATE 4: SELESAI -->
            <template x-if="status === 'selesai'">
                <div class="p-8 sm:p-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-cyan-100 mb-4 shadow-inner">
                        <span class="text-4xl">🏆</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-blue-600 mb-2">Kuis Selesai!</h2>
                    <p class="text-slate-500 font-medium mb-6">Kerja bagus! Berikut adalah hasil akhirmu.</p>

                    <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto mb-6">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Skor Benar</p>
                            <p class="text-2xl font-black text-slate-800">
                                <span x-text="hasilAkhir.jumlah_benar"></span><span class="text-slate-400 text-lg mx-1">/</span><span class="text-lg text-slate-500" x-text="soal.length"></span>
                            </p>
                        </div>
                        <div class="bg-cyan-50 p-4 rounded-2xl border border-cyan-100">
                            <p class="text-xs font-bold text-cyan-600 uppercase tracking-wider mb-1">XP Didapat</p>
                            <p class="text-2xl font-black text-cyan-800" x-text="'+' + hasilAkhir.xp_didapat"></p>
                        </div>
                    </div>

                    <p class="text-slate-700 font-medium mb-1">Level Sekarang: <strong class="text-cyan-700 text-lg" x-text="hasilAkhir.level"></strong></p>

                    <template x-if="hasilAkhir.sudah_main_hari_ini">
                        <div class="bg-amber-50 border border-amber-200 text-amber-700 text-xs p-3 rounded-lg max-w-sm mx-auto mb-4">
                            Kamu sudah mendapat XP hari ini. Sesi ini hanya dihitung sebagai latihan.
                        </div>
                    </template>

                    <template x-if="hasilAkhir.kartu_baru && hasilAkhir.kartu_baru.length > 0">
                        <div class="mt-4 p-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white shadow-lg max-w-sm mx-auto">
                            <p class="text-xs font-bold text-indigo-100 uppercase tracking-wider mb-1">✨ Kartu Baru Terbuka!</p>
                            <p class="font-semibold" x-text="hasilAkhir.kartu_baru.join(', ')"></p>
                        </div>
                    </template>

                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('kuis.index') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all text-sm">Main Lagi</a>
                        <a href="{{ route('kartu.index') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-cyan-500 text-cyan-700 font-semibold rounded-xl hover:bg-cyan-50 transition-all text-sm">Lihat Koleksi</a>
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
                    <p class="text-slate-600 font-medium mb-8 max-w-sm mx-auto">Sesi kuis ini tidak dihitung karena waktu telah berakhir. Coba lagi dan jawab dengan lebih cepat!</p>
                    <a href="{{ route('kuis.index') }}"
                        class="inline-block px-8 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 shadow-md hover:shadow-lg hover:shadow-red-500/30 transition-all">Coba Lagi</a>
                </div>
            </template>

        </div>
    </div>

    @push('scripts')
        <script>
            function kuisApp() {
                return {
                    status: 'awal',
                    // Hanya teks di layar awal. Samakan dengan JUMLAH_SOAL dan DURASI_DETIK di KuisService.
                    info: { soal: 5, menit: 5 },

                    gameId: null,
                    deadlineAt: null,
                    soal: [],
                    indexSoal: 0,
                    sisaDetik: 0,
                    terkunci: false,
                    catatan: {},            // { [soalId]: { pilihan, kunci } } hanya untuk tampilan ulang
                    konfirmasiSelesai: false,
                    hasilAkhir: null,
                    pesanError: '',
                    timer: null,

                    get soalSekarang() {
                        return this.soal[this.indexSoal] ?? {};
                    },

                    get catatanSekarang() {
                        return this.catatan[this.soalSekarang.id] ?? null;
                    },

                    get jumlahDijawab() {
                        return Object.keys(this.catatan).length;
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

                    // Sesi dibuat di server hanya setelah tombol Mulai ditekan
                    async mulai() {
                        if (this.status !== 'awal') return;
                        this.status = 'memuat';
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

                    // Navigasi antar soal (hanya mengganti soal yang ditampilkan)
                    pindah(i) {
                        this.indexSoal = i;
                        this.pesanError = '';
                        this.konfirmasiSelesai = false;
                    },
                    sebelumnya() { if (this.indexSoal > 0) this.pindah(this.indexSoal - 1); },
                    berikutnya() { if (this.indexSoal < this.soal.length - 1) this.pindah(this.indexSoal + 1); },

                    kelasNomor(s, i) {
                        let kelas = 'w-10 h-10 rounded-xl font-bold text-sm border-2 transition ';
                        const c = this.catatan[s.id];
                        if (c) {
                            kelas += c.pilihan === c.kunci
                                ? 'bg-emerald-50 border-emerald-400 text-emerald-700'
                                : 'bg-red-50 border-red-300 text-red-600';
                        } else {
                            kelas += 'bg-white border-slate-200 text-slate-600 hover:border-cyan-300';
                        }
                        if (i === this.indexSoal) kelas += ' ring-2 ring-cyan-400 ring-offset-2';
                        return kelas;
                    },

                    kelasOpsi(opsi) {
                        const c = this.catatanSekarang;
                        if (c === null) {
                            return 'border-slate-200 hover:border-cyan-400 hover:bg-cyan-50/50 hover:shadow-md text-slate-700 bg-white cursor-pointer';
                        }
                        if (opsi === c.kunci) {
                            return 'border-emerald-500 bg-emerald-50 text-emerald-900 shadow-sm shadow-emerald-100 z-10 cursor-default';
                        }
                        if (opsi === c.pilihan) {
                            return 'border-red-400 bg-red-50 text-red-900 shadow-sm shadow-red-100 z-10 cursor-default';
                        }
                        return 'border-slate-100 bg-slate-50 opacity-50 text-slate-400 cursor-default grayscale-[50%]';
                    },

                    kelasHuruf(opsi) {
                        const c = this.catatanSekarang;
                        if (c === null) return 'text-slate-600';
                        if (opsi === c.kunci) return 'text-emerald-600 border-emerald-300';
                        if (opsi === c.pilihan) return 'text-red-500 border-red-300';
                        return 'text-slate-600';
                    },

                    // Penilaian tetap di server. Di sini hanya mengirim pilihan dan menyimpan balasannya untuk tampilan.
                    async jawabSoal(opsi) {
                        if (this.terkunci || this.catatanSekarang !== null) return;
                        const soalId = this.soalSekarang.id;
                        this.terkunci = true;
                        this.pesanError = '';

                        try {
                            const data = await this.panggil(`/kuis/${this.gameId}/jawab`, {
                                soal_id: soalId,
                                pilihan: opsi,
                            });
                            this.catatan = { ...this.catatan, [soalId]: { pilihan: opsi, kunci: data.jawaban_benar } };
                        } catch (e) {
                            if (/waktu/i.test(e.message)) {
                                clearInterval(this.timer);
                                this.status = 'habis_waktu';
                            } else {
                                this.pesanError = e.message;
                            }
                        } finally {
                            this.terkunci = false;
                        }
                    },

                    async selesaiKuis() {
                        if (this.jumlahDijawab < this.soal.length && !this.konfirmasiSelesai) {
                            this.konfirmasiSelesai = true;
                            return;
                        }
                        this.konfirmasiSelesai = false;
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
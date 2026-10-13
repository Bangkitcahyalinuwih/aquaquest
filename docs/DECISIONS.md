# Keputusan Desain dan Penyimpangan dari SKPL

Dokumen ini mencatat setiap keputusan teknis penting dan alasan tim. Rangkuman rencana eksekusi 2 minggu menjadi acuan
utama; SKPL menjadi referensi pendukung. Perbedaan dari SKPL bersifat disengaja karena batas waktu dua minggu, bukan kelalaian.

## A. Perbedaan terhadap SKPL

| #   | Item di SKPL                                             | Keputusan                                                           | Alasan                                                                                    | Status         |
| --- | -------------------------------------------------------- | ------------------------------------------------------------------- | ----------------------------------------------------------------------------------------- | -------------- |
| A1  | Backend Node/Express atau Django, frontend React/Flutter | Laravel 12 monolith + Blade                                         | Satu codebase, integrasi cepat, cocok untuk waktu 2 minggu                                | Diganti        |
| A2  | REST API + JWT                                           | Aplikasi server-rendered dengan sesi (Laravel Breeze)               | Konsekuensi A1; tidak ada klien terpisah. Endpoint JSON hanya untuk kuis (AJAX)           | Diganti        |
| A3  | Aplikasi mobile Android/iOS                              | Web responsif                                                       | Batas waktu; kebutuhan lintas perangkat dipenuhi lewat browser                            | Diganti        |
| A4  | Entitas ADMIN terpisah                                   | Satu tabel `users` dengan kolom `role` (`user`/`admin`)             | Selaras dengan Breeze; pemisahan akses dijaga middleware `role:admin` dan prefix `/admin` | Diganti        |
| A5  | Notifikasi push (FCM)                                    | Tidak dibuat                                                        | Di luar lingkup 2 minggu                                                                  | Ditunda        |
| A6  | Google Maps atau OSM                                     | Leaflet + OpenStreetMap                                             | Gratis dan tanpa API key                                                                  | Dipilih        |
| A7  | Relasi Biota:Konten edukasi = 1:1                        | `konten_edukasi.biota_id` nullable                                  | Memungkinkan artikel umum yang tidak terikat biota                                        | Diubah         |
| A8  | Entitas GAME dengan detail riwayat                       | Satu tabel `game_history` dengan kolom JSON (`soal_ids`, `jawaban`) | Cukup untuk validasi server tanpa tabel detail tambahan                                   | Disederhanakan |
| A9  | Achievement                                              | Tabel `kartu` (master) dan `koleksi_kartu` (pivot)                  | Menyelaraskan konsep achievement dengan fitur kartu                                       | Diperjelas     |

## B. Keputusan teknis dan proses

| # | Keputusan | Alasan |
|---|---|---|
| B1 | Commit awal langsung ke `main`, setelah itu seluruh kerja lewat branch dan Pull Request | Repo kosong tidak dapat dibuat PR; dilakukan sekali |
| B2 | Default branch `dev`; `main` hanya menerima rilis bertag | Menjaga `main` selalu stabil untuk demo |
| B3 | Integritas kuis di server: kunci jawaban tidak dikirim ke klien, XP, level, dan batas waktu dihitung server | Timer dan umpan balik di Alpine.js hanya tampilan; skor di JavaScript dapat dimanipulasi |
| B4 | Logika bisnis di kelas Service (`KuisService`, `LevelService`, `KartuService`, `GambarService`, `SlugService`) | Controller tetap tipis dan logika mudah diuji |
| B5 | Aturan anti-farming: hanya sesi selesai pertama setiap hari yang menambah XP | Mencegah XP didapat dengan mengulang kuis tanpa batas |
| B6 | Zona waktu aplikasi `Asia/Jakarta` | Pergantian "hari" untuk jatah XP harian terjadi pukul 00.00 WIB, bukan 07.00 WIB (UTC) |
| B7 | Pembatas laju (`throttle`) 60 permintaan per menit pada endpoint kuis | Mengurangi penyalahgunaan endpoint |
| B8 | Eksplisit nama parameter route resource (`parameters([...])`) | Pluralisasi bahasa Inggris dapat mengubah `biota` menjadi `biotum` sehingga binding model gagal |
| B9 | Slug dibuat unik otomatis dan tidak diubah saat edit | Mencegah error database untuk nama sama dan menjaga tautan lama |
| B10 | Upload gambar divalidasi `image`, `jpg/jpeg/png/webp`, maksimal 2 MB, disimpan di disk `public` | Mencegah file berbahaya dan menjaga ukuran |
| B11 | Gambar seed disimpan di repo (`database/seeders/images`) dan disalin oleh seeder | Semua laptop, termasuk laptop demo, memiliki data gambar yang sama |
| B12 | Seeder data riil tanpa faker | Mode demo memakai `composer install --no-dev` |
| B13 | Review silang antar anggota mulai tahap 4; merge dilakukan setelah approve | Menjaga kualitas dan pembagian pengetahuan |
| B14 | Test lokal memakai SQLite in-memory | Cepat dijalankan; query yang dipakai tidak bergantung pada fitur khusus satu DBMS |
| B15 | Demo dijalankan lokal di laptop Repo Master, bukan di hosting atau Docker | Mengurangi risiko saat presentasi; Docker menambah kerumitan pada tim dengan dua sistem operasi berbeda |
| B16 | Halaman error (403/404/419/429/500/503) berdiri sendiri tanpa layout aplikasi | Tetap tampil walau error disebabkan database atau aset |

## C. Tambahan di luar SKPL

| # | Tambahan | Keterangan |
|---|---|---|
| C1 | Pencarian dan filter kategori | Mempermudah penelusuran ensiklopedia dan edukasi |
| C2 | Dashboard pengguna dan dashboard admin ringkas | Progres XP, kartu berikutnya, status jatah XP harian; statistik dasar untuk admin |
| C3 | Akun demo dan pemain contoh pada seeder | Pengguna demo diberi XP 80 agar satu sesi kuis memicu naik level dan kartu baru |

## D. Tidak dikerjakan (future work)

- Kelola data pengguna oleh admin (UC-15) dan laporan aktivitas rinci (UC-14)
- Audit log admin (`activity_logs`)
- Aplikasi mobile native, notifikasi push, pemindaian biota
- Pemulihan akun dengan email produksi (fitur Breeze tersedia, memakai `log` mailer)
- Deploy ke hosting dan CI/CD otomatis (bergantung penyelesaian item opsional)
- Pembaruan massal status konservasi dari sumber IUCN

## E. Catatan data

- Status konservasi mengacu pada IUCN Red List (global) dan dapat berubah. Contoh: penyu hijau (*Chelonia mydas*)
  diturunkan dari Endangered ke Least Concern pada Oktober 2025. Verifikasi ulang di iucnredlist.org sebelum dipakai di luar demo.
- Koordinat biota merupakan perkiraan lokasi habitat atau pengamatan yang dikenal, bukan titik survei presisi.

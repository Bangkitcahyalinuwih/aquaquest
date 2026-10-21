# AquaQuest

Aplikasi edukasi interaktif berbasis gamifikasi tentang biota air Indonesia, mendukung **SDG 14: Life Below Water**.
Proyek Politeknik Negeri Madiun, Program Studi Teknologi Rekayasa Perangkat Lunak, Kelas 2A.

<!-- TODO: tempel 3-4 screenshot (beranda, detail biota dengan peta, kuis, koleksi kartu, dashboard admin) di folder docs/screenshots -->

## Fitur

**Pengguna (masyarakat)**

- Daftar, masuk, ubah profil
- Ensiklopedia biota dengan pencarian dan filter kategori, detail biota dengan peta persebaran (Leaflet + OpenStreetMap)
- Materi edukasi dengan pencarian
- Kuis pilihan ganda hybrid (soal teks dan tebak gambar) dengan timer; XP, level, dan kartu koleksi
- Koleksi kartu virtual (terkunci/terbuka), peringkat Top XP, dashboard progres
- Target Belajar dengan banner pengingat 

**Admin (dinas terkait)**

- Dashboard ringkasan (jumlah data, pemain teratas, sesi kuis terbaru)
- CRUD biota, konten edukasi, bank soal kuis, dan kartu, termasuk upload gambar

**Aturan permainan**

- Satu sesi = 5 soal acak, batas waktu 5 menit
- XP sesi = jumlah poin soal yang benar; **hanya sesi pertama yang selesai setiap hari yang menambah XP** (anti-farming)
- Level = `floor(total_xp / 100) + 1`
- Kartu terbuka otomatis saat total XP mencapai syarat kartu

## Teknologi

| Lapisan     | Teknologi                                                                  |
| ----------- | -------------------------------------------------------------------------- |
| Backend     | PHP 8.3, Laravel 12 (monolith, Blade)                                      |
| Autentikasi | Laravel Breeze (Blade)                                                     |
| Frontend    | Blade, Tailwind CSS, Alpine.js (Vite), Flowbite sebagai referensi komponen |
| Database    | MySQL 8                                                                    |
| Peta        | Leaflet.js + OpenStreetMap                                                 |
| Pengujian   | Pest, Laravel Pint                                                         |

Alasan pemilihan teknologi dan perbedaan dari SKPL: [docs/DECISIONS.md](docs/DECISIONS.md).

## Menjalankan secara lokal

Prasyarat: PHP 8.3 (ekstensi mbstring, xml, curl, mysql, gd, intl, zip), Composer 2, Node 22, MySQL 8, Git.

```bash
git clone <TODO-url-repo> aquaquest && cd aquaquest
composer install
cp .env.example .env
php artisan key:generate
# buat database "aquaquest" (utf8mb4), lalu sesuaikan DB_USERNAME dan DB_PASSWORD di .env
php artisan migrate:fresh --seed
php artisan storage:link        # Windows: jalankan terminal sebagai Administrator
npm ci && npm run build
php artisan serve
```

Untuk pengembangan, jalankan `npm run dev` di terminal terpisah. Di Windows/Laragon jangan memakai `composer dev`.

## Akun demo (khusus lokal)

| Peran                                  | Email                                                  | Kata sandi |
| -------------------------------------- | ------------------------------------------------------ | ---------- |
| Admin                                  | `admin@aquaquest.test`                                 | `password` |
| Pengguna demo (XP 80, siap naik level) | `demo@aquaquest.test`                                  | `password` |
| Pemain contoh                          | `pemain1@aquaquest.test` s.d. `pemain8@aquaquest.test` | `password` |

Ganti seluruh kata sandi ini bila aplikasi dipasang di luar lingkungan demo.

## Pengujian

```bash
php artisan test            # Pest: logika kuis/XP/level/kartu, hak akses, CRUD admin, upload, pencarian, seeder
vendor/bin/pint --test      # pemeriksaan gaya kode
```

Cakupan utama: anti-kecurangan kuis (batas waktu, kepemilikan sesi, soal di luar sesi, jawaban ganda, selesai ganda,
anti-farming XP), pembukaan kartu, otorisasi admin, redirect per peran, validasi dan upload gambar.

## Struktur dan alur kerja tim

Git Flow: `main` (rilis) ← `dev` (integrasi) ← `feature/*`, `frontend/*`, `docs/*`, `chore/*`.
Semua perubahan lewat Pull Request, commit mengikuti Conventional Commits (`feat`, `fix`, `style`, `docs`, `test`, `chore`).

Dokumen: [Keputusan desain](docs/DECISIONS.md), [ERD](docs/ERD.md), [Alur pengguna](docs/ALUR-PENGGUNA.md),
[Kredit gambar](docs/KREDIT-GAMBAR.md).

## Keterbatasan dan pengembangan lanjutan

Tidak termasuk dalam versi ini (lihat daftar lengkap di DECISIONS): aplikasi mobile native, notifikasi push, kelola data
pengguna oleh admin dan laporan aktivitas rinci, audit log admin, pemindaian biota, dan deploy ke hosting.

## Tim

| Nama                       | NIM       | Peran                   |
| -------------------------- | --------- | ----------------------- |
| Bangkit Cahya Linuwih      | 254311027 | Backend dan Repo Master |
| Aisyah Nur Fadillah (Dila) | 254311001 | Backend                 |
| Abdul Aziz Mushthofa       | 254311015 | UI/UX dan Frontend      |
| Silfina Nur Fadilah        | 254311007 | UI/UX dan Frontend      |

## Lisensi dan kredit

Gambar biota berasal dari sumber berlisensi terbuka; daftar pembuat dan lisensi ada di [docs/KREDIT-GAMBAR.md](docs/KREDIT-GAMBAR.md).
Status konservasi mengacu pada IUCN Red List dan dapat berubah saat penilaian diperbarui.

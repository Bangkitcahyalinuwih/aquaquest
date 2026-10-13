# ERD dan Alur Kuis

## ERD final

```mermaid
erDiagram
    USERS ||--o{ GAME_HISTORY : "memainkan"
    USERS ||--o{ KOLEKSI_KARTU : "mengoleksi"
    BIOTA |o--o{ KONTEN_EDUKASI : "dijelaskan oleh"
    BIOTA |o--o{ SOAL_KUIS : "menjadi topik"
    BIOTA ||--o| KARTU : "punya"
    KARTU ||--o{ KOLEKSI_KARTU : "dikoleksi"

    USERS {
        bigint id PK
        string name
        string email UK
        string password
        enum role "user, admin"
        int total_xp "default 0, indeks"
        int level "default 1"
    }
    BIOTA {
        bigint id PK
        string nama
        string nama_latin
        string slug UK
        string kategori "indeks"
        text deskripsi
        string habitat
        string status_konservasi
        string gambar
        decimal latitude
        decimal longitude
    }
    KONTEN_EDUKASI {
        bigint id PK
        bigint biota_id FK "nullable"
        string judul
        string slug UK
        longtext isi
        string gambar
    }
    SOAL_KUIS {
        bigint id PK
        bigint biota_id FK "nullable"
        enum tipe "teks, gambar"
        text pertanyaan
        string gambar
        string opsi_a
        string opsi_b
        string opsi_c
        string opsi_d
        enum jawaban_benar "a, b, c, d"
        int poin "default 10"
    }
    KARTU {
        bigint id PK
        bigint biota_id FK "unik"
        string nama
        string gambar
        int xp_syarat "indeks"
    }
    GAME_HISTORY {
        bigint id PK
        bigint user_id FK
        datetime mulai_at
        datetime deadline_at
        datetime selesai_at "nullable"
        enum status "berjalan, selesai, kedaluwarsa"
        json soal_ids
        json jawaban
        int jumlah_benar
        int xp_didapat
    }
    KOLEKSI_KARTU {
        bigint id PK
        bigint user_id FK
        bigint kartu_id FK
        datetime didapat_at
    }
```
Batasan tambahan: `koleksi_kartu` unik pada pasangan (`user_id`, `kartu_id`); `game_history` memiliki indeks gabungan
(`user_id`, `status`, `selesai_at`) untuk pemeriksaan jatah XP harian.

## Alur kuis (integritas di server)

```mermaid
sequenceDiagram
    participant P as Pemain (Alpine.js)
    participant S as Server (KuisService)
    participant D as Database

    P->>S: POST /kuis/mulai
    S->>D: pilih 5 soal acak, simpan sesi (status berjalan, deadline +5 menit)
    S-->>P: game_id, deadline_at, soal (TANPA jawaban_benar)

    loop untuk setiap soal
        P->>S: POST /kuis/{game}/jawab (soal_id, pilihan)
        S->>S: cek pemilik sesi, status berjalan, belum lewat deadline, soal ada di sesi, belum dijawab
        S->>D: simpan jawaban
        S-->>P: benar/salah dan jawaban_benar
    end

    P->>S: POST /kuis/{game}/selesai
    S->>S: hitung poin dari jawaban tersimpan
    S->>D: sesi pertama hari ini? jika ya, tambah total_xp
    S->>S: hitung level, buka kartu yang syaratnya terpenuhi
    S-->>P: jumlah_benar, xp_didapat, level, kartu_baru
```
Timer di layar hanya tampilan yang dihitung dari `deadline_at`; keputusan menerima atau menolak jawaban selalu di server.

## Arsitektur lapisan

```
Browser (Blade + Tailwind + Alpine.js, Leaflet)
        |  HTTP (halaman) / JSON (kuis)
Routes -> Middleware (auth, role, throttle) -> Controller (tipis)
        |
Service (KuisService, LevelService, KartuService, GambarService, SlugService)
        |
Model Eloquent  ->  MySQL
```

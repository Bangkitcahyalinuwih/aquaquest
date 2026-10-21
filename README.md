# Fitur Komentar Biota pada AquaQuest

**Tugas UTS Pemrograman Web**

|                     |                                                                      |
| ------------------- | -------------------------------------------------------------------- |
| Nama                | `Bangkit Cahya Linuwih`                                              |
| NIM                 | `254311027`                                                          |
| Kelas               | `3A`                                                                 |
| Program Studi       | Teknologi Rekayasa Perangkat Lunak, Politeknik Negeri Madiun         |
| Mata kuliah / Dosen | Pemrograman Web / `Bayu Prasetiyo Utomo, S.Kom., M.Eng.`             |
| Proyek dasar        | AquaQuest (Laravel 12, aplikasi edukasi biota air Indonesia, SDG 14) |

## 1. Deskripsi fitur

**Komentar Biota** memungkinkan pengguna yang sudah login berdiskusi pada halaman detail setiap biota. Pengguna dapat
**menambah, melihat, mengubah, dan menghapus** komentar miliknya. Admin dapat menghapus komentar siapa pun untuk moderasi,
tetapi tidak dapat mengubah isinya. Tamu (belum login) hanya dapat membaca komentar.

**Tujuan:** menambah interaksi antarpengguna sehingga AquaQuest tidak hanya menjadi sumber bacaan, tetapi juga ruang
berbagi pengetahuan tentang biota laut.

## 2. Hak akses

| Peran    | Lihat |           Tambah           |     Ubah      |     Hapus      |
| -------- | :---: | :------------------------: | :-----------: | :------------: |
| Tamu     |  ya   | tidak (diarahkan ke login) |     tidak     |     tidak      |
| Pengguna |  ya   |             ya             | milik sendiri | milik sendiri  |
| Admin    |  ya   |             ya             |     tidak     | semua komentar |

## 3. Penerapan MVC dan CRUD

Fitur mengikuti pola **Model-View-Controller** pada Laravel.

| Komponen               | Berkas                                        | Peran                                                               |
| ---------------------- | --------------------------------------------- | ------------------------------------------------------------------- |
| **Model**              | `app/Models/Komentar.php`                     | Mewakili tabel `komentar`; relasi `belongsTo` ke `Biota` dan `User` |
| **Model (relasi)**     | `Biota::komentar()`, `User::komentar()`       | Relasi `hasMany`                                                    |
| **View**               | `resources/views/biota/_komentar.blade.php`   | Daftar komentar, form tambah, tombol ubah dan hapus                 |
| **View**               | `resources/views/komentar/edit.blade.php`     | Form ubah komentar                                                  |
| **Controller**         | `app/Http/Controllers/KomentarController.php` | Method `store`, `edit`, `update`, `destroy`                         |
| **Controller**         | `BiotaController@show`                        | Mengambil komentar dan mengirimkannya ke view                       |
| **Validasi**           | `app/Http/Requests/SimpanKomentarRequest.php` | Aturan dan pesan kesalahan                                          |
| **Otorisasi**          | `app/Policies/KomentarPolicy.php`             | Siapa boleh mengubah dan menghapus                                  |
| **Route**              | `routes/web.php`                              | Empat route di grup `auth`                                          |
| **Migration**          | `create_komentar_table`                       | Skema tabel                                                         |
| **Seeder dan Factory** | `KomentarSeeder`, `KomentarFactory`           | Data contoh dan data uji                                            |
| **Test**               | `tests/Feature/KomentarTest.php`              | Pengujian otomatis (Pest)                                           |

| Operasi CRUD | Route                                                                                 | Method controller      |
| ------------ | ------------------------------------------------------------------------------------- | ---------------------- |
| **Create**   | `POST /biota/{slug}/komentar` (`komentar.store`)                                      | `store`                |
| **Read**     | `GET /biota/{slug}` (bagian komentar)                                                 | `BiotaController@show` |
| **Update**   | `GET /komentar/{id}/edit` (`komentar.edit`), `PUT /komentar/{id}` (`komentar.update`) | `edit`, `update`       |
| **Delete**   | `DELETE /komentar/{id}` (`komentar.destroy`)                                          | `destroy`              |

Fitur mengikuti pola **Model-View-Controller** pada Laravel.

| Komponen               | Berkas                                        | Peran                                                               |
| ---------------------- | --------------------------------------------- | ------------------------------------------------------------------- |
| **Model**              | `app/Models/Komentar.php`                     | Mewakili tabel `komentar`; relasi `belongsTo` ke `Biota` dan `User` |
| **Model (relasi)**     | `Biota::komentar()`, `User::komentar()`       | Relasi `hasMany`                                                    |
| **View**               | `resources/views/biota/_komentar.blade.php`   | Daftar komentar, form tambah, tombol ubah dan hapus                 |
| **View**               | `resources/views/komentar/edit.blade.php`     | Form ubah komentar                                                  |
| **Controller**         | `app/Http/Controllers/KomentarController.php` | Method `store`, `edit`, `update`, `destroy`                         |
| **Controller**         | `BiotaController@show`                        | Mengambil komentar dan mengirimkannya ke view                       |
| **Validasi**           | `app/Http/Requests/SimpanKomentarRequest.php` | Aturan dan pesan kesalahan                                          |
| **Otorisasi**          | `app/Policies/KomentarPolicy.php`             | Siapa boleh mengubah dan menghapus                                  |
| **Route**              | `routes/web.php`                              | Empat route di grup `auth`                                          |
| **Migration**          | `create_komentar_table`                       | Skema tabel                                                         |
| **Seeder dan Factory** | `KomentarSeeder`, `KomentarFactory`           | Data contoh dan data uji                                            |
| **Test**               | `tests/Feature/KomentarTest.php`              | Pengujian otomatis (Pest)                                           |

| Operasi CRUD | Route                                                                                 | Method controller      |
| ------------ | ------------------------------------------------------------------------------------- | ---------------------- |
| **Create**   | `POST /biota/{slug}/komentar` (`komentar.store`)                                      | `store`                |
| **Read**     | `GET /biota/{slug}` (bagian komentar)                                                 | `BiotaController@show` |
| **Update**   | `GET /komentar/{id}/edit` (`komentar.edit`), `PUT /komentar/{id}` (`komentar.update`) | `edit`, `update`       |
| **Delete**   | `DELETE /komentar/{id}` (`komentar.destroy`)                                          | `destroy`              |

## 4. Alur penggunaan

1. Pengguna membuka detail biota, lalu menggulir ke bagian **Komentar**.
2. Tamu melihat tautan **Masuk untuk berkomentar**; pengguna yang login melihat form komentar.
3. Pengguna menulis komentar lalu menekan **Kirim Komentar**. Sistem memvalidasi, menyimpan, kembali ke bagian komentar,
   dan menampilkan pesan sukses.
4. Pada komentar miliknya, pengguna melihat tautan **Ubah** dan tombol **Hapus**. Pada halaman ubah, isi komentar
   diperbarui lalu pengguna kembali ke daftar.
5. Admin melihat tombol **Hapus** pada semua komentar.
6. Daftar komentar dipaginasi 5 komentar per halaman.

## 5. Struktur berkas yang ditambah atau diubah

```
app/
  Http/Controllers/KomentarController.php        (baru)
  Http/Controllers/BiotaController.php           (diubah: method show)
  Http/Requests/SimpanKomentarRequest.php        (baru)
  Models/Komentar.php                            (baru)
  Models/Biota.php, Models/User.php              (diubah: relasi komentar)
  Policies/KomentarPolicy.php                    (baru)
database/
  migrations/..._create_komentar_table.php       (baru)
  factories/KomentarFactory.php                  (baru)
  seeders/KomentarSeeder.php                     (baru), DatabaseSeeder.php (diubah)
resources/views/
  biota/_komentar.blade.php                      (baru)
  biota/show.blade.php                           (diubah: @include komentar)
  komentar/edit.blade.php                        (baru)
routes/web.php                                   (diubah: 4 route)
tests/Feature/KomentarTest.php                   (baru)
```

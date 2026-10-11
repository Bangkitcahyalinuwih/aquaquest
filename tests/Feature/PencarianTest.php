<?php

use App\Models\Biota;
use App\Models\KontenEdukasi;

test('pencarian biota menyaring hasil', function () {
    Biota::factory()->create(['nama' => 'Penyu Hijau', 'slug' => 'penyu-hijau', 'kategori' => 'Reptil Laut']);
    Biota::factory()->create(['nama' => 'Ikan Badut', 'slug' => 'ikan-badut', 'kategori' => 'Ikan']);

    $this->get('/biota?q=penyu')->assertOk()->assertSee('Penyu Hijau')->assertDontSee('Ikan Badut');
});

test('filter kategori biota menyaring hasil', function () {
    Biota::factory()->create(['nama' => 'Penyu Hijau', 'slug' => 'penyu-hijau', 'kategori' => 'Reptil Laut']);
    Biota::factory()->create(['nama' => 'Ikan Badut', 'slug' => 'ikan-badut', 'kategori' => 'Ikan']);

    $this->get('/biota?kategori=Ikan')->assertOk()->assertSee('Ikan Badut')->assertDontSee('Penyu Hijau');
});

test('pencarian edukasi menyaring hasil', function () {
    KontenEdukasi::factory()->create(['judul' => 'Tentang Lamun', 'slug' => 'tentang-lamun']);
    KontenEdukasi::factory()->create(['judul' => 'Tentang Plastik', 'slug' => 'tentang-plastik', 'isi' => 'abc']);

    $this->get('/edukasi?q=lamun')->assertOk()->assertSee('Tentang Lamun')->assertDontSee('Tentang Plastik');
});

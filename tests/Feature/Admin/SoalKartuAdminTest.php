<?php

use App\Models\Biota;
use App\Models\Kartu;
use App\Models\SoalKuis;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('user biasa mendapat 403 di halaman admin soal dan kartu', function (string $nama) {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)->get(route($nama))->assertForbidden();
})->with(['admin.soal.index', 'admin.kartu.index']);

test('admin dapat menambah soal teks', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->post(route('admin.soal.store'), [
        'tipe' => 'teks',
        'pertanyaan' => 'Apa nama ilmiah penyu hijau?',
        'opsi_a' => 'Chelonia mydas',
        'opsi_b' => 'B',
        'opsi_c' => 'C',
        'opsi_d' => 'D',
        'jawaban_benar' => 'a',
        'poin' => 10,
    ])->assertRedirect(route('admin.soal.index'));

    $this->assertDatabaseHas('soal_kuis', ['pertanyaan' => 'Apa nama ilmiah penyu hijau?']);
});

test('soal bertipe gambar wajib punya gambar', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->post(route('admin.soal.store'), [
        'tipe' => 'gambar',
        'pertanyaan' => 'Hewan apa ini?',
        'opsi_a' => 'A',
        'opsi_b' => 'B',
        'opsi_c' => 'C',
        'opsi_d' => 'D',
        'jawaban_benar' => 'b',
        'poin' => 10,
    ])->assertSessionHasErrors('gambar');
});

test('admin dapat mengubah dan menghapus soal', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $soal = SoalKuis::factory()->create();

    $this->actingAs($admin)->put(route('admin.soal.update', $soal), [
        'tipe' => 'teks',
        'pertanyaan' => 'Pertanyaan baru',
        'opsi_a' => 'A',
        'opsi_b' => 'B',
        'opsi_c' => 'C',
        'opsi_d' => 'D',
        'jawaban_benar' => 'c',
        'poin' => 20,
    ])->assertRedirect(route('admin.soal.index'));

    expect($soal->fresh()->pertanyaan)->toBe('Pertanyaan baru');
    expect($soal->fresh()->poin)->toBe(20);

    $this->actingAs($admin)->delete(route('admin.soal.destroy', $soal));
    $this->assertDatabaseMissing('soal_kuis', ['id' => $soal->id]);
});

test('admin dapat menambah kartu dan satu biota hanya boleh punya satu kartu', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);
    $biota = Biota::factory()->create();

    $data = fn() => [
        'biota_id' => $biota->id,
        'nama' => 'Kartu Uji',
        'xp_syarat' => 100,
        'gambar' => UploadedFile::fake()->image('kartu.png'),
    ];

    $this->actingAs($admin)->post(route('admin.kartu.store'), $data())
        ->assertRedirect(route('admin.kartu.index'));

    $this->actingAs($admin)->post(route('admin.kartu.store'), $data())
        ->assertSessionHasErrors('biota_id');

    expect(Kartu::count())->toBe(1);
});

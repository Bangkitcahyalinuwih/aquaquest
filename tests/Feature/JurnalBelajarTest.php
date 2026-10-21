<?php

use App\Models\JurnalBelajar;
use App\Models\KontenEdukasi;
use App\Models\User;

test('user dapat menyimpan jurnal', function () {
    $user = User::factory()->create();
    $artikel = KontenEdukasi::factory()->create();

    $this->actingAs($user)->post(route('jurnal.store'), [
        'konten_edukasi_id' => $artikel->id,
        'ringkasan' => 'Ringkasan artikel ini lebih dari dua puluh karakter.',
        'status' => 'selesai',
        'rating' => 5,
    ])->assertRedirect(route('jurnal.index'));

    $this->assertDatabaseHas('jurnal_belajar', ['user_id' => $user->id, 'rating' => 5]);
});

test('rating wajib saat status selesai', function () {
    $user = User::factory()->create();
    $artikel = KontenEdukasi::factory()->create();

    $this->actingAs($user)->post(route('jurnal.store'), [
        'konten_edukasi_id' => $artikel->id,
        'ringkasan' => 'Ringkasan artikel ini lebih dari dua puluh karakter.',
        'status' => 'selesai',
    ])->assertSessionHasErrors('rating');
});

test('artikel yang sama tidak dapat dijurnalkan dua kali', function () {
    $user = User::factory()->create();
    $artikel = KontenEdukasi::factory()->create();
    $data = [
        'konten_edukasi_id' => $artikel->id,
        'ringkasan' => 'Ringkasan artikel ini lebih dari dua puluh karakter.',
        'status' => 'sedang_dibaca',
    ];

    $this->actingAs($user)->post(route('jurnal.store'), $data);
    $this->actingAs($user)->post(route('jurnal.store'), $data)->assertSessionHasErrors('konten_edukasi_id');

    expect(JurnalBelajar::count())->toBe(1);
});

test('user tidak dapat menghapus jurnal milik orang lain', function () {
    $pemilik = User::factory()->create();
    $jurnal = JurnalBelajar::create([
        'user_id' => $pemilik->id,
        'konten_edukasi_id' => KontenEdukasi::factory()->create()->id,
        'ringkasan' => 'Ringkasan artikel ini lebih dari dua puluh karakter.',
        'status' => 'sedang_dibaca',
    ]);

    $this->actingAs(User::factory()->create())
        ->delete(route('jurnal.destroy', $jurnal))
        ->assertForbidden();
});

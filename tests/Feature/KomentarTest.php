<?php

use App\Models\Biota;
use App\Models\Komentar;
use App\Models\User;

test('tamu tidak dapat berkomentar', function () {
    $biota = Biota::factory()->create();

    $this->post(route('komentar.store', $biota), ['isi' => 'Halo semua'])->assertRedirect('/login');

    expect(Komentar::count())->toBe(0);
});

test('pengguna dapat menambah komentar', function () {
    $user = User::factory()->create();
    $biota = Biota::factory()->create();

    $this->actingAs($user)
        ->post(route('komentar.store', $biota), ['isi' => 'Biota yang menarik'])
        ->assertRedirect(route('biota.show', $biota) . '#komentar');

    $this->assertDatabaseHas('komentar', [
        'biota_id' => $biota->id,
        'user_id' => $user->id,
        'isi' => 'Biota yang menarik',
    ]);
});

test('komentar kosong atau terlalu pendek ditolak', function (string $isi) {
    $user = User::factory()->create();
    $biota = Biota::factory()->create();

    $this->actingAs($user)->post(route('komentar.store', $biota), ['isi' => $isi])
        ->assertSessionHasErrors('isi');

    expect(Komentar::count())->toBe(0);
})->with(['', 'ab']);

test('komentar tampil di halaman detail biota', function () {
    $biota = Biota::factory()->create();
    Komentar::factory()->create(['biota_id' => $biota->id, 'isi' => 'Komentar uji tampil']);

    $this->get(route('biota.show', $biota))->assertOk()->assertSee('Komentar uji tampil');
});

test('tamu melihat ajakan masuk, bukan form komentar', function () {
    $biota = Biota::factory()->create();

    $this->get(route('biota.show', $biota))->assertSee('Masuk untuk berkomentar');
});

test('pemilik dapat mengubah komentarnya', function () {
    $user = User::factory()->create();
    $komentar = Komentar::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->put(route('komentar.update', $komentar), ['isi' => 'Isi sudah diubah'])
        ->assertRedirect();

    expect($komentar->fresh()->isi)->toBe('Isi sudah diubah');
});

test('pengguna lain tidak dapat mengubah atau menghapus komentar orang', function () {
    $pemilik = User::factory()->create();
    $lain = User::factory()->create();
    $komentar = Komentar::factory()->create(['user_id' => $pemilik->id, 'isi' => 'Asli']);

    $this->actingAs($lain)->get(route('komentar.edit', $komentar))->assertForbidden();
    $this->actingAs($lain)->put(route('komentar.update', $komentar), ['isi' => 'Dibajak'])->assertForbidden();
    $this->actingAs($lain)->delete(route('komentar.destroy', $komentar))->assertForbidden();

    expect($komentar->fresh()->isi)->toBe('Asli');
});

test('pemilik dapat menghapus komentarnya', function () {
    $user = User::factory()->create();
    $komentar = Komentar::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->delete(route('komentar.destroy', $komentar))->assertRedirect();

    $this->assertDatabaseMissing('komentar', ['id' => $komentar->id]);
});

test('admin dapat menghapus komentar siapa pun tetapi tidak dapat mengubahnya', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $komentar = Komentar::factory()->create();

    $this->actingAs($admin)->put(route('komentar.update', $komentar), ['isi' => 'Diubah admin'])->assertForbidden();
    $this->actingAs($admin)->delete(route('komentar.destroy', $komentar))->assertRedirect();

    $this->assertDatabaseMissing('komentar', ['id' => $komentar->id]);
});

test('menghapus biota ikut menghapus komentarnya', function () {
    $biota = Biota::factory()->create();
    Komentar::factory()->count(3)->create(['biota_id' => $biota->id]);

    $biota->delete();

    expect(Komentar::count())->toBe(0);
});

test('komentar berisi script di-escape sehingga aman dari xss', function () {
    $biota = Biota::factory()->create();
    Komentar::factory()->create(['biota_id' => $biota->id, 'isi' => '<script>alert(1)</script>']);

    $html = $this->get(route('biota.show', $biota))->assertOk();

    $html->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);   // false = cek HTML mentah
    $html->assertDontSee('<script>alert(1)</script>', false);
});

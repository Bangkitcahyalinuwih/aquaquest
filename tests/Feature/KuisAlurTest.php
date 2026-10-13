<?php

use App\Models\SoalKuis;
use App\Models\User;

test('alur kuis lengkap menambah xp dan tidak membocorkan kunci jawaban', function () {
    $user = User::factory()->create();
    SoalKuis::factory()->count(6)->create(['jawaban_benar' => 'a', 'poin' => 10]);

    $mulai = $this->actingAs($user)->postJson('/kuis/mulai');

    $mulai->assertOk()
        ->assertJsonStructure(['game_id', 'deadline_at', 'soal'])
        ->assertJsonCount(5, 'soal')
        ->assertJsonMissingPath('soal.0.jawaban_benar');

    foreach ($mulai->json('soal') as $soal) {
        $this->actingAs($user)
            ->postJson('/kuis/'.$mulai->json('game_id').'/jawab', ['soal_id' => $soal['id'], 'pilihan' => 'a'])
            ->assertOk()
            ->assertJson(['benar' => true]);
    }

    $this->actingAs($user)
        ->postJson('/kuis/'.$mulai->json('game_id').'/selesai')
        ->assertOk()
        ->assertJson(['jumlah_benar' => 5, 'xp_didapat' => 50, 'level' => 1]);

    expect($user->fresh()->total_xp)->toBe(50);
});

test('selesai dua kali ditolak dan xp tidak bertambah lagi', function () {
    $user = User::factory()->create();
    SoalKuis::factory()->count(5)->create(['jawaban_benar' => 'a']);

    $id = $this->actingAs($user)->postJson('/kuis/mulai')->json('game_id');
    $this->actingAs($user)->postJson("/kuis/{$id}/selesai")->assertOk();
    $this->actingAs($user)->postJson("/kuis/{$id}/selesai")->assertStatus(422);
});

test('pengguna lain tidak dapat memakai sesi orang lain', function () {
    $pemilik = User::factory()->create();
    $penyusup = User::factory()->create();
    $soal = SoalKuis::factory()->count(5)->create(['jawaban_benar' => 'a']);

    $mulai = $this->actingAs($pemilik)->postJson('/kuis/mulai');
    $id = $mulai->json('game_id');

    $this->actingAs($penyusup)
        ->postJson("/kuis/{$id}/jawab", ['soal_id' => $mulai->json('soal.0.id'), 'pilihan' => 'a'])
        ->assertForbidden();
});

test('kuis tidak dapat dimulai bila belum ada soal', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->postJson('/kuis/mulai')->assertStatus(422);
});

test('tamu tidak dapat memulai kuis', function () {
    $this->postJson('/kuis/mulai')->assertUnauthorized();
});

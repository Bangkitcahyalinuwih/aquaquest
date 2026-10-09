<?php

use App\Models\GameHistory;
use App\Models\SoalKuis;
use App\Models\User;
use App\Services\KuisService;

test('jawaban ditolak setelah deadline lewat', function () {
    $user = User::factory()->create();
    $soal = SoalKuis::factory()->create(['jawaban_benar' => 'a', 'poin' => 10]);

    $game = GameHistory::create([
        'user_id' => $user->id,
        'mulai_at' => now()->subMinutes(10),
        'deadline_at' => now()->subMinute(), // sengaja sudah lewat
        'status' => 'berjalan',
        'soal_ids' => [$soal->id],
        'jawaban' => [],
    ]);

    app(KuisService::class)->jawab($game, $soal->id, 'a');
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class);

test('soal yang bukan bagian sesi ditolak', function () {
    $user = User::factory()->create();
    $soalDalamSesi = SoalKuis::factory()->create();
    $soalLuarSesi = SoalKuis::factory()->create();

    $game = GameHistory::create([
        'user_id' => $user->id,
        'mulai_at' => now(),
        'deadline_at' => now()->addMinutes(5),
        'status' => 'berjalan',
        'soal_ids' => [$soalDalamSesi->id],
        'jawaban' => [],
    ]);

    app(KuisService::class)->jawab($game, $soalLuarSesi->id, 'a');
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class);

test('xp tidak bertambah di sesi kedua pada hari yang sama', function () {
    $user = User::factory()->create(['total_xp' => 0]);
    $soal = SoalKuis::factory()->create(['jawaban_benar' => 'a', 'poin' => 10]);
    $service = app(KuisService::class);

    // Sesi pertama
    $game1 = GameHistory::create([
        'user_id' => $user->id,
        'mulai_at' => now(),
        'deadline_at' => now()->addMinutes(5),
        'status' => 'berjalan',
        'soal_ids' => [$soal->id],
        'jawaban' => [$soal->id => 'a'],
    ]);
    $hasil1 = $service->selesai($game1);

    // Sesi kedua, hari yang sama
    $game2 = GameHistory::create([
        'user_id' => $user->id,
        'mulai_at' => now(),
        'deadline_at' => now()->addMinutes(5),
        'status' => 'berjalan',
        'soal_ids' => [$soal->id],
        'jawaban' => [$soal->id => 'a'],
    ]);
    $hasil2 = $service->selesai($game2);

    expect($hasil1['xp_didapat'])->toBe(10);
    expect($hasil2['xp_didapat'])->toBe(0);
    expect($user->fresh()->total_xp)->toBe(10);
});

test('kartu terbuka otomatis saat xp mencapai syarat', function () {
    $user = User::factory()->create(['total_xp' => 90]);
    $kartu = \App\Models\Kartu::factory()->create(['xp_syarat' => 100]);
    $soal = SoalKuis::factory()->create(['jawaban_benar' => 'a', 'poin' => 10, 'biota_id' => $kartu->biota_id]);

    $game = GameHistory::create([
        'user_id' => $user->id,
        'mulai_at' => now(),
        'deadline_at' => now()->addMinutes(5),
        'status' => 'berjalan',
        'soal_ids' => [$soal->id],
        'jawaban' => [$soal->id => 'a'],
    ]);

    $hasil = app(KuisService::class)->selesai($game);

    expect($user->fresh()->total_xp)->toBe(100);
    expect($hasil['kartu_baru'])->toContain($kartu->nama);
});

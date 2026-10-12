<?php

test('seeder data riil berjalan dan membuat data yang konsisten', function () {
    $this->seed();

    expect(\App\Models\Biota::count())->toBe(10);
    expect(\App\Models\Kartu::count())->toBe(10);
    expect(\App\Models\SoalKuis::where('tipe', 'teks')->count())->toBe(24);

    // Setiap soal punya jawaban benar a-d yang opsinya terisi.
    foreach (\App\Models\SoalKuis::all() as $soal) {
        expect($soal->{'opsi_' . $soal->jawaban_benar})->not->toBeEmpty();
    }

    expect(\App\Models\User::where('role', 'admin')->count())->toBe(1);
});

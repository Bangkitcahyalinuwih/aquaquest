<?php

use App\Models\Biota;
use App\Models\Kartu;
use App\Models\SoalKuis;
use App\Models\User;

test('seeder data riil berjalan dan membuat data yang konsisten', function () {
    $this->seed();

    expect(Biota::count())->toBe(10);
    expect(Kartu::count())->toBe(10);
    expect(SoalKuis::where('tipe', 'teks')->count())->toBe(24);

    // Setiap soal punya jawaban benar a-d yang opsinya terisi.
    foreach (SoalKuis::all() as $soal) {
        expect($soal->{'opsi_'.$soal->jawaban_benar})->not->toBeEmpty();
    }

    expect(User::where('role', 'admin')->count())->toBe(1);
});

<?php

namespace Database\Seeders;

use App\Models\Biota;
use App\Models\Komentar;
use App\Models\User;
use Illuminate\Database\Seeder;

class KomentarSeeder extends Seeder
{
    public function run(): void
    {
        $biota = Biota::pluck('id', 'slug');
        $pengguna = User::where('role', 'user')->pluck('id', 'email');

        $data = [
            ['penyu-hijau', 'pemain1@aquaquest.test', 'Baru tahu penyu hijau memakan lamun. Menjaga padang lamun berarti ikut menjaga penyu.'],
            ['hiu-paus', 'pemain2@aquaquest.test', 'Hiu paus raksasa tetapi jinak, keren! Ingin melihatnya langsung di Teluk Cenderawasih.'],
            ['ikan-badut', 'pemain3@aquaquest.test', 'Hubungan ikan badut dan anemon adalah contoh simbiosis mutualisme yang bagus.'],
            ['dugong', 'demo@aquaquest.test', 'Semoga padang lamun tempat dugong hidup terus terjaga.'],
        ];

        foreach ($data as [$slug, $email, $isi]) {
            if (isset($biota[$slug], $pengguna[$email])) {
                Komentar::firstOrCreate(['biota_id' => $biota[$slug], 'user_id' => $pengguna[$email], 'isi' => $isi]);
            }
        }
    }
}

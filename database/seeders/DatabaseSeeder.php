<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $biota = \App\Models\Biota::factory()->count(10)->create();

        $biota->each(function ($item) {
            \App\Models\Kartu::factory()->create([
                'biota_id' => $item->id,
            ]);
        });

        \App\Models\KontenEdukasi::factory()->count(6)->create();

        // \App\Models\Biota::factory()->count(10)->create();
    }
}

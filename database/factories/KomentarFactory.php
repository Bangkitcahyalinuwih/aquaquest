<?php

namespace Database\Factories;

use App\Models\Komentar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Komentar>
 */
class KomentarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'biota_id' => \App\Models\Biota::factory(),
            'user_id' => \App\Models\User::factory(),
            'isi' => fake()->sentence(8),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Edukasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KomentarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_video' => Edukasi::inRandomOrder()->first()->id ?? Edukasi::factory(),
            'id_user' => User::inRandomOrder()->first()->id ?? User::factory(),
            'isi' => $this->faker->paragraph(),
            'tanggal_komentar' => $this->faker->date(),
        ];
    }
}

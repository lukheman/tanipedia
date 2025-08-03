<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence,
            'isi' => $this->faker->paragraphs(3, true),
            'tanggal_publikasi' => $this->faker->date(),
            'id_user' => User::factory(),
        ];
    }
}

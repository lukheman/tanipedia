<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Edukasi>
 */
class EdukasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $videoFiles = [
            '6xiuwucIRRuULXsC7HBA0QGZ1KaclBMw83Ctbwsa.mp4',
            'Avy5DrOxoNqQWuhww1MpAYrcXkLCHhwtdUTmQvwM.mp4',
            '8DqTRroycFF5FfJidrypiP6DKt9Y62wiMhklVJqE.mp4',
            'gWsqZrEipmVLjlPwNJtNeibYVOsa3XJXNt84Tiz7.mp4',
        ];

        return [
            'id_user' => User::factory(),
            'judul' => $this->faker->sentence(6),
            'tanggal_publikasi' => $this->faker->date(),
            'deskripsi' => $this->faker->paragraph(2),
            'url_video' => 'videos/'.$this->faker->randomElement($videoFiles),
        ];
    }
}

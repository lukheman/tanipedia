<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Berita;
use App\Models\Edukasi;
use App\Models\Komentar;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => Role::ADMIN->value,
        ]);

        User::factory()->create([
            'name' => 'Petani 1',
            'email' => 'petani1@gmail.com',
            'role' => Role::PETANI->value,
        ]);

        User::factory()->create([
            'name' => 'Petani 2',
            'email' => 'petani2@gmail.com',
            'role' => Role::PETANI->value,
        ]);

        User::factory()->create([
            'name' => 'Ahli Pertanian',
            'email' => 'ahlipertanian@gmail.com',
            'role' => Role::AHLIPERTANIAN->value,
        ]);

        User::factory()->create([
            'name' => 'KEPALADINAS',
            'email' => 'kepaladinas@gmail.com',
            'role' => Role::KEPALADINAS->value,
        ]);

        // User::factory(10)->create();
        // Berita::factory(5)->create();
        // Edukasi::factory(8)->create();
        // Komentar::factory(20)->create();

    }
}

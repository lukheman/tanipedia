<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Berita;
use App\Models\Edukasi;
use App\Models\Komentar;
use App\Models\User;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa kecamatan
        $kecamatan = \App\Models\Kecamatan::factory(3)->create();

        // Buat beberapa desa per kecamatan
        $desaList = collect();
        $kecamatan->each(function ($kec) use (&$desaList) {
            $desaList = $desaList->merge(
                Desa::factory(3)->create([
                    'id_kecamatan'=> $kec->id
                ])
            );
        });

        // Ambil daftar desa secara acak untuk dipakai user
        $desaIds = $desaList->pluck('id');
        $kecamatanIds = $kecamatan->pluck('id');

        // Buat user dengan id_desa secara acak
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => Role::ADMIN->value,
            'id_desa' => $desaIds->random(),
        ]);

        User::factory()->create([
            'name' => 'Petani 1',
            'email' => 'petani1@gmail.com',
            'role' => Role::PETANI->value,
            'id_desa' => $desaIds->random(),
        ]);

        User::factory()->create([
            'name' => 'Petani 2',
            'email' => 'petani2@gmail.com',
            'role' => Role::PETANI->value,
            'id_desa' => $desaIds->random(),
        ]);

        User::factory()->create([
            'name' => 'Ahli Pertanian',
            'email' => 'ahlipertanian@gmail.com',
            'role' => Role::AHLIPERTANIAN->value,
            'id_desa' => $desaIds->random(),
        ]);

        User::factory()->create([
            'name' => 'KEPALADINAS',
            'email' => 'kepaladinas@gmail.com',
            'role' => Role::KEPALADINAS->value,
            'id_desa' => $desaIds->random(),
        ]);

        // Uncomment jika ingin menambahkan dummy data
        // User::factory(10)->create();
        // Berita::factory(5)->create();
        // Edukasi::factory(8)->create();
        // Komentar::factory(20)->create();
    }
}

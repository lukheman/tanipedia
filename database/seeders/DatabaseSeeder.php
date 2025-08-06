<?php

use App\Enums\Role;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data kecamatan dan desa
        $wilayah = [
            ['Baula', ['Baula', 'Longori', 'Pewutaa', 'Puubenua', 'Puubunga', 'Puulemo', 'Puundoho', 'Puuroda', 'Ulu Baula', 'Watalara']],
            ['Iwoimendaa', ['Iwoimendaa', 'Ladahai', 'Lambopini', 'Landoula', 'Lasiroku', 'Lawolia', 'Tamborasi', 'Ulu Kalo', 'Watumelewe', 'Wonualaku']],
            ['Kolaka', ['Balandete', 'Laloeha', 'Lalombaa', 'Lamokato', 'Sabilambo', 'Tahoa', 'Watuliandu']],
            ['Latambaga', ['Induha', 'Kolakaasi', 'Latambaga', 'Mangolo', 'Sakuli', 'Sea', 'Ulunggolaka']],
            ['Polinggona', ['Lamondape', 'Plasma Jaya', 'Polinggona', 'Pondowae', 'Puudongi', 'Tanggeau', 'Wulonggere']],
            ['Pomalaa', ['Dawi-Dawi', 'Hakatutobu', 'Huko-Huko', 'Kumoro', 'Oko-Oko', 'Pelambua', 'Pesouha', 'Pomalaa', 'Sopura', 'Tambea', 'Tonggoni', 'Totobo']],
            ['Samaturu', ['Amamutu', 'Awa', 'Kaloloa', 'Konaweha', 'Lambolemo', 'Latuo', 'Lawulo', 'Liku', 'Malaha', 'Meura', 'Puu Lawulo', 'Puu Tamboli', 'Sani-sani', 'Tamboli', 'Tonganapo', 'Tosiba', 'Ulaweng', 'Ulu Konaweha', 'Wawo Tambali']],
            ['Tanggetada', ['Anaiwoi', 'Lalonggolosua', 'Lamedai', 'Lamoiko', 'Oneeha', 'Palewai', 'Petudua', 'Pewisoa Jaya', 'Popalia', 'Puundaipa', 'Rahanggada', 'Tanggetada', 'Tinggo', 'Tondowolio']],
            ['Toari', ['Anawua', 'Horongkuli', 'Lakito', 'Rahabite', 'Rano Jaya', 'Rano Sangia', 'Ranomentaa', 'Toari', 'Wonua Raya', 'Wowoli']],
            ['Watubangga', ['Gunung Sari', 'Kastura', 'Kukutio', 'Lamundre', 'Langgosipi', 'Mataosu', 'Mataosu Ujung', 'Peoho', 'Polenga', 'Ranoteta', 'Sumber Rejeki', 'Tandebura', 'Watubangga', 'Wolulu']],
            ['Wolo', ['Donggala', 'Iwoimopuro', 'Lalonaha', 'Lalonggopi', 'Lana', 'Langgomali', 'Lapao-Pao', 'Muara Lapao-Pao', 'Samaenre', 'Tolowe Ponrewaru', 'Ulu Rina', 'Ulu Wolo', 'Ululapao-pao', 'Wolo']],
            ['Wundulako', ['19 Nopember', 'Bende', 'Kowioha', 'Lamekongga', 'Ngapa', 'Sabiano', 'Silea', 'Tikonu', 'Towua', 'Unamendaa', 'Wundulako']],
        ];

        $desaList = collect();

        foreach ($wilayah as [$namaKecamatan, $desaDesa]) {
            $kecamatan = Kecamatan::create(['nama' => $namaKecamatan]);
            foreach ($desaDesa as $namaDesa) {
                $desaList->push(
                    Desa::create([
                        'id_kecamatan' => $kecamatan->id,
                        'nama' => $namaDesa,
                    ])
                );
            }
        }

        // Ambil daftar desa secara acak untuk dipakai user
        $desaIds = $desaList->pluck('id');

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
    }
}

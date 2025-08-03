<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Berita;
use App\Models\Edukasi;
use App\Models\User;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard', [
            'jumlah_petani' => User::where('role', Role::PETANI->value)->count(),
            'jumlah_ahli_pertanian' => User::where('role', Role::AHLIPERTANIAN->value)->count(),
            'jumlah_berita' => Berita::count(),
            'jumlah_video' => Edukasi::count(),
        ]);
    }
}

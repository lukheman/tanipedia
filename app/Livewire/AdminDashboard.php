<?php

namespace App\Livewire;

use App\Models\Berita;
use App\Models\Edukasi;
use App\Models\User;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard', [
            'jumlah_petani' => User::count(),
            'jumlah_ahli_pertanian' => User::count(),
            'jumlah_berita' => Berita::count(),
            'jumlah_video' => Edukasi::count(),
        ]);
    }
}

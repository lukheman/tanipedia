<?php

namespace App\Livewire;

use App\Models\Konsultasi;
use Livewire\Component;

class AhliPertanianDashboard extends Component
{
    public function render()
    {
        return view('livewire.ahli-pertanian-dashboard', [ 
            'jumlah_konsultasi' => Konsultasi::count()
        ]);
    }
}

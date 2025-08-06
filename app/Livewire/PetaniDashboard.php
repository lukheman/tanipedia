<?php

namespace App\Livewire;

use App\Models\Konsultasi;
use Livewire\Component;

class PetaniDashboard extends Component
{
    public function render()
    {
        return view('livewire.petani-dashboard', [
            'jumlah_konsultasi' => Konsultasi::where('id', auth()->id())->count(),
        ]);
    }
}

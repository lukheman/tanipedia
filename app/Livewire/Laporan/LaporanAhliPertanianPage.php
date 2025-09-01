<?php

namespace App\Livewire\Laporan;

use App\Enums\Role;
use App\Models\Penyuluh;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Penyuluh Pertanian')]
class LaporanAhliPertanianPage extends Component
{
    public function render()
    {
        return view('livewire.laporan.laporan-ahli-pertanian-page', [

            'users' => Penyuluh::latest()->paginate(10),
        ]);
    }
}

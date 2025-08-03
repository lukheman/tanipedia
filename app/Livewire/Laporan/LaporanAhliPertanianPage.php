<?php

namespace App\Livewire\Laporan;

use App\Enums\Role;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Ahli Pertanian')]
class LaporanAhliPertanianPage extends Component
{
    public function render()
    {
        return view('livewire.laporan.laporan-ahli-pertanian-page', [

            'users' => User::where('role', Role::AHLIPERTANIAN->value)->paginate(10),
        ]);
    }
}

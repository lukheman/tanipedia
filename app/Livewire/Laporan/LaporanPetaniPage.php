<?php

namespace App\Livewire\Laporan;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Laporan Petani')]
class LaporanPetaniPage extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.laporan.laporan-petani-page', [
            'users' => User::latest()->paginate(10),
        ]);
    }
}

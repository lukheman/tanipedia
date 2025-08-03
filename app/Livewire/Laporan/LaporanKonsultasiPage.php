<?php

namespace App\Livewire\Laporan;

use App\Models\Konsultasi;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Konsultasi')]
class LaporanKonsultasiPage extends Component
{
    public function render()
    {
        return view('livewire.laporan.laporan-konsultasi-page', [
            'konsultasi' => Konsultasi::with('user')->get(),
        ]);
    }
}

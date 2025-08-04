<?php

namespace App\Livewire\Laporan;

use App\Models\Konsultasi;
use App\Traits\Traits\WithModal;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Konsultasi')]
class LaporanKonsultasiPage extends Component
{
    use WithModal;

    public $kecamatan;

    public function render()
    {
        return view('livewire.laporan.laporan-konsultasi-page', [
            'konsultasi' => Konsultasi::with('user')->get(),
        ]);
    }
}

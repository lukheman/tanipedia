<?php

namespace App\Livewire\Laporan;

use App\Enums\Role;
use App\Models\Konsultasi;
use App\Traits\Traits\WithModal;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Konsultasi')]
class LaporanKonsultasiPage extends Component
{
    use WithModal;

    public ?Konsultasi $selectedKonsultasi;

    public string $nama_petani = '';
    public string $nama_penyuluh = '';
    public string $tanggal_konsultasi = '';
    public string $nama_tanaman = '';


    public function detail($id)
    {

        $this->selectedKonsultasi = Konsultasi::with('tanaman', 'user', 'penyuluh')->find($id);
        $this->nama_petani = $this->selectedKonsultasi->user->name;
        $this->nama_penyuluh = $this->selectedKonsultasi->penyuluh->name;
        $this->tanggal_konsultasi = $this->selectedKonsultasi->tanggal_konsultasi;
        $this->nama_tanaman = $this->selectedKonsultasi->tanaman->nama;
        $this->openModal('modal-detail-konsultasi');

    }

    public function render()
    {
        return view('livewire.laporan.laporan-konsultasi-page', [
            'konsultasi' => Konsultasi::with('user')->get(),
        ]);
    }
}

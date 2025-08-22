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

    public $selectedIKonsultasi;

    public $nama_petani = '';

    public $isi = '';

    public $nama_tanaman = '';

    public $tanggal_konsultasi = '';

    public function detail($konsultasi)
    {
        $this->selectedIKonsultasi = $konsultasi['id'];
        $this->nama_petani = $konsultasi['user']['name'];
        $this->isi = $konsultasi['isi'];
        $this->nama_tanaman = $konsultasi['nama_tanaman'];
        $this->tanggal_konsultasi = $konsultasi['tanggal_konsultasi'];

        $konsultasi = Konsultasi::with('hasil', 'hasil.user')->find($konsultasi['id']);
        if ($konsultasi->hasil) {
            $this->nama_ahli_pertanian = $konsultasi->hasil->user->name;
            $this->jawaban = $konsultasi->hasil->isi;
        }

        $this->openModal('modal-detail-konsultasi');

    }

    public function render()
    {
        return view('livewire.laporan.laporan-konsultasi-page', [
            'konsultasi' => Konsultasi::with('user')->get(),
        ]);
    }
}

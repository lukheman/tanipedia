<?php

namespace App\Livewire;

use App\Models\Konsultasi;
use App\Models\Tanaman;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Buat Konsultasi Baru')]
class FormKonsultasiPage extends Component
{
    use WithNotify;

    #[Validate('required|exists:tanaman,id_tanaman')]
    public $id_tanaman = '';

    #[Validate('required|string', message: 'Deskripsi masalah wajib diisi.')]
    public $isi = '';

    public $tanamanList;

    public function mount()
    {
        $this->tanamanList = Tanaman::all();
    }

    public function submit()
    {
        $this->validate();

        try {

            Konsultasi::create([
                'id_petani' => Auth::guard('petani')->user()->id_petani,
                'id_tanaman' => $this->id_tanaman,
                'isi' => $this->isi,
                'tanggal_konsultasi' => now()->toDateString(),
            ]);

            $this->notifySuccess('Konsultasi berhasil dikirim!');

            $this->reset(['id_tanaman', 'isi']);

        } catch (\Exception $e) {
            $this->notifyError('Gagal mengirim konsultasi: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.form-konsultasi-page');
    }
}

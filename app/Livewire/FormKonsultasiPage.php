<?php

namespace App\Livewire;

use App\Models\Konsultasi;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Buat Konsultasi Baru')]
class FormKonsultasiPage extends Component
{
    use WithNotify;

    #[Validate('required|string|max:255', message: 'Jenis tanaman wajib diisi dan maksimal 255 karakter.')]
    public $nama_tanaman = '';

    #[Validate('required|string', message: 'Deskripsi masalah wajib diisi.')]
    public $isi = '';

    public function submit()
    {
        $this->validate();

        try {

            Konsultasi::create([
                'id_user' => Auth::id(),
                'nama_tanaman' => $this->nama_tanaman,
                'isi' => $this->isi,
                'tanggal_konsultasi' => now()->toDateString(),
            ]);

            $this->notifySuccess('Konsultasi berhasil dikirim!');

            $this->reset(['nama_tanaman', 'isi']);

        } catch (\Exception $e) {
            $this->notifyError('Gagal mengirim konsultasi: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.form-konsultasi-page');
    }
}

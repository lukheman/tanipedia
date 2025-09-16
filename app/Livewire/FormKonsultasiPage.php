<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Enums\StatusKonsultasi;
use App\Models\Konsultasi;
use App\Models\Pesan;
use App\Models\Tanaman;
use App\Models\Penyuluh;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Buat Konsultasi Baru')]
class FormKonsultasiPage extends Component
{
    use WithNotify;
    use WithModal;

    #[Validate('required|exists:tanaman,id_tanaman', message: 'Tanaman wajib dipilih.')]
    public $id_tanaman = '';

    #[Validate('required|exists:penyuluh,id_penyuluh', message: 'Penyuluh wajib dipilih.')]
    public $id_penyuluh= '';

    // #[Validate('required|string', message: 'Deskripsi masalah wajib diisi.')]
    // public $isi = '';

    public $tanamanList;

    public $penyuluhList;

    public function mount()
    {
        $this->tanamanList = Tanaman::all();
        $this->penyuluhList = Penyuluh::all();
    }

    public function updatedIdTanaman($value)
    {
        $this->penyuluhList = Penyuluh::query()->whereHas('tanaman', function ($query) use ($value) {
            $query->where('id_tanaman', $value);
        })->get();
    }


    public function submit()
    {
        $this->validate();

        try {

            $id_petani = getActiveUserId(); // harus id petani

            // cek apakah ada konsultasi yang belum selesai dengan penyuluh yang sama
            $konsultasiBelumSelesai = Konsultasi::query()
                ->where('id_petani', $id_petani)
                ->where('id_penyuluh', $this->id_penyuluh)
                ->where('status', StatusKonsultasi::ACCEPTED)
                ->exists();

            if($konsultasiBelumSelesai) {
                $this->notifyWarning('Masih ada konsultasi yang belum selesai dengan penyuluh ini');
                return;
            }

            $konsutasi = Konsultasi::query()->create([
                'id_petani' => Auth::guard('petani')->user()->id_petani,
                'id_penyuluh' => $this->id_penyuluh,
                'id_tanaman' => $this->id_tanaman,
                'tanggal_konsultasi' => now()->toDateString(),
            ]);

            $this->notifySuccess('Konsultasi berhasil dikirim!');

            $this->reset(['id_tanaman']);
            $this->closeModal('modal-form-konsultasi');
            $this->dispatch('refreshListChats');

        } catch (\Exception $e) {
            $this->notifyError('Gagal mengirim konsultasi: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.form-konsultasi-page');
    }
}

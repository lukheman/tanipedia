<?php

namespace App\Livewire\Konsultasi;

use App\Enums\Role;
use App\Enums\StatusKonsultasi;
use App\Models\Konsultasi;
use App\Traits\WithNotify;
use App\Livewire\Forms\PesanForm;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class DisplayChat extends Component
{
    use WithNotify;
    use WithFileUploads;

    public ?Konsultasi $konsultasi = null;
    public Role $activeRole;

    // Form pesan
    public PesanForm $form;

    #[On('display')]
    public function display($idKonsultasi)
    {
        $this->konsultasi = Konsultasi::query()
            ->with(['user', 'tanaman', 'pesan', 'penyuluh'])
            ->find($idKonsultasi);

        if ($this->konsultasi && $this->konsultasi->status === StatusKonsultasi::PENDING) {
            flash('Silahkan tunggu penyuluh untuk menerima permintaan konsultasi Anda', 'warning');
        }

        // set id konsultasi di form
        $this->form->id_konsultasi = $this->konsultasi?->id_konsultasi;
    }

    public function mount()
    {
        $this->activeRole = Role::from(getActiveGuard());
        $this->form->role_pengirim = $this->activeRole->value;
        $this->form->id_pengirim = getActiveUserId();
    }

    public function kirimPesan()
    {
        try {
            // isi otomatis ID konsultasi
            $this->form->id_konsultasi = $this->konsultasi?->id_konsultasi;
            $this->form->id_pengirim = getActiveUserId();
            $this->form->role_pengirim = $this->activeRole->value;

            // simpan data via form
            $this->form->store();

            $this->notifySuccess('Pesan berhasil dikirim');
        } catch (\Throwable $e) {
            $this->notifyError('Gagal mengirim pesan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.konsultasi.display-chat');
    }
}

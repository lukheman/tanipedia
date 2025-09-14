<?php

namespace App\Livewire\Konsultasi;

use App\Enums\Role;
use App\Enums\StatusKonsultasi;
use App\Models\Konsultasi;
use App\Models\Pesan;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DisplayChat extends Component
{
    use WithNotify;

    public ?Konsultasi $konsultasi;


    #[Validate('required|min:1')]
    public string $pesan = '';

    public Role $activeRole;


    #[On('display')]
    public function display($idKonsultasi) {

        $this->konsultasi = Konsultasi::query()->with(['user', 'tanaman', 'pesan','penyuluh'])->find($idKonsultasi);

        if($this->konsultasi->status === StatusKonsultasi::PENDING) {
            flash('Silahkan tunggu penyuluh untuk menerima permintaan konsultasi Anda', 'warning');
        }


    }

    public function mount() {
        $this->activeRole = Role::from(getActiveGuard());
    }

    public function kirimPesan() {

        $this->validate();
        $user = getActiveUser();

        Pesan::query()->create([
            'id_konsultasi' => $this->konsultasi->id_konsultasi,
            'id_pengirim' => getActiveUserId(),
            'role_pengirim' => $this->activeRole,
            'isi' => $this->pesan
        ]);

        $this->notifySuccess('Pesan berhasil dikirim');

    }

    public function render()
    {
        return view('livewire.konsultasi.display-chat');
    }
}

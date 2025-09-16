<?php

namespace App\Livewire\Konsultasi;

use App\Enums\Role;
use App\Enums\StatusKonsultasi;
use App\Models\Konsultasi;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use StatusKonsultasi as StatusKonsultasiStatusKonsultasi;

class ListChats extends Component
{
    use WithNotify;

    public ?Konsultasi $selectedKonsultasi;

    public Role $activeRole;

    #[On('refreshListChats')]
    public function refreshComponent() {
        $this->dispatch('$refresh');
    }

    public function mount() {
        $this->activeRole = Role::from(getActiveGuard());
    }


    #[Computed]
    public function konsultasiList() {
        $guard = getActiveGuard(); // guard aktif
        $user = getActiveUser();

        $this->dispatch('setActiveRole', role: $guard);

        if ($guard === Role::PETANI->value) {
            $konsultasi = Konsultasi::query()
                ->where('id_petani', $user->id_petani)
                ->where('status', '!=', StatusKonsultasi::REJECTED)->get();
            return $konsultasi;
        }

        return Konsultasi::with(['user', 'tanaman'])
        ->whereHas('tanaman', function ($query) use ($user) {
            if ($user && $user->id_tanaman) {
                $query->where('id_tanaman', $user->id_tanaman)
                    ->where('status', StatusKonsultasi::ACCEPTED);
            }
        })->get();

    }

    public function select($id) {
        $this->dispatch('display', idKonsultasi: $id);
    }

    public function delete($id) {

        $this->selectedKonsultasi = Konsultasi::find($id);
        $this->dispatch('deleteConfirmation', message: 'Apakah Anda yakin untuk membatalkan konsultasi ini?');

    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed() {
        try {
            $this->selectedKonsultasi->delete();
            $this->notifySuccess('Konsultasi berhasil dibatalkan');
            $this->redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus pengguna: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.konsultasi.list-chats');
    }
}

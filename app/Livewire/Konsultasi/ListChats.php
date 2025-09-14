<?php

namespace App\Livewire\Konsultasi;

use App\Enums\Role;
use App\Enums\StatusKonsultasi;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListChats extends Component
{

    public Role $activeRole;

    public function mount() {
        $this->activeRole = Role::from(getActiveGuard());
    }


    #[Computed]
    public function konsultasiList() {
        $guard = getActiveGuard(); // guard aktif
        $user = getActiveUser();

        $this->dispatch('setActiveRole', role: $guard);

        if ($guard === Role::PETANI->value) {
            $user->load('konsultasi');
            $user->konsultasi->load('penyuluh');
            return $user->konsultasi;
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

    public function render()
    {
        return view('livewire.konsultasi.list-chats');
    }
}

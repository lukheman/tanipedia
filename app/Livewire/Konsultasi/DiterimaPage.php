<?php

namespace App\Livewire\Konsultasi;

use App\Models\Konsultasi;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Enums\StatusKonsultasi;

#[Title('Konsultasi')]
class DiterimaPage extends Component
{
    use WithNotify;

    #[Computed]
    public function konsultasiList() {
        $guard = getActiveGuard(); // guard aktif
        $user = Auth::guard($guard)->user();

        return Konsultasi::with(['user', 'tanaman'])
        ->whereHas('tanaman', function ($query) use ($user) {
            if ($user && $user->id_tanaman) {
                $query->where('id_tanaman', $user->id_tanaman)
                    ->where('status', StatusKonsultasi::ACCEPTED);
            }
        })->get();

    }

    public function render()
    {
        return view('livewire.konsultasi.diterima-page');
    }
}

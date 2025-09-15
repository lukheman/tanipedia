<?php

namespace App\Livewire;

use App\Models\Desa;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AhliPertanianDashboard extends Component
{
    public function render()
    {
        $user = getActiveUser();

        return view('livewire.ahli-pertanian-dashboard', [
            'jumlah_konsultasi' => Konsultasi::with(['tanaman', 'user'])
                ->whereHas('tanaman', function ($query) use ($user) {
                    if($user) {
                        $query->where('id_tanaman', $user->id_tanaman);
                    }

                })->count(),
        ]);
    }
}

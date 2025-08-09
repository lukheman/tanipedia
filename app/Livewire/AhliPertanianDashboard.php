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
        return view('livewire.ahli-pertanian-dashboard', [
            'jumlah_konsultasi' => Konsultasi::with(['user.desa'])
                ->whereHas('user.desa', function ($query) {

                    $currentUser = Auth::user();
                    if ($currentUser && $currentUser->id_desa) {
                        $kecamatanId = Desa::find($currentUser->id_desa)->id_kecamatan;
                        $query->where('id_kecamatan', $kecamatanId);
                    }

                })->count(),
        ]);
    }
}

<?php

namespace App\Livewire\Laporan;

use App\Enums\Role;
use App\Models\Penyuluh;
use App\Models\User;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanPenggunaPage extends Component
{

    public string $tipe_laporan = 'petani'; // petani atau penyuluh

    public function download() {
        if ($this->tipe_laporan === 'petani') {
            return redirect()->route('print-laporan.petani');
        } elseif($this->tipe_laporan === 'penyuluh') {
            return redirect()->route('print-laporan.ahli-pertanian');
        }
    }

    public function render()
    {

        $petani = User::with('desa')->get()->map(function ($item) {
            $item->id = $item->id_petani;

            return $item;
        });

        $penyuluh = Penyuluh::with('desa')->get()->map(function ($item) {
            $item->id = $item->id_penyuluh;

            return $item;
        });

        $allUsers = $petani
            ->concat($penyuluh);

        // Sortir berdasarkan created_at
        $allUsers = $allUsers->sortByDesc('created_at');

        // Paginasi manual
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allUsers->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator(
            $currentItems,
            $allUsers->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.laporan.laporan-pengguna-page', [
            'users' => $paginated
        ]);
    }
}

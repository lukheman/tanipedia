<?php

namespace App\Livewire\Laporan;

use App\Enums\Role;
use App\Models\Kecamatan;
use App\Models\Penyuluh;
use App\Models\Tanaman;
use App\Models\User;
use App\Traits\Traits\WithModal;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanPenggunaPage extends Component
{
    use WithModal;

    public ?string $tipe_laporan = 'petani'; // petani atau penyuluh

    public ?int $id_kecamatan = null;
    public ?int $id_tanaman = null;


    public string $idModal = 'modal-cetak-laporan-konsultasi';

    public function tanamanList() {
        return Tanaman::all();
    }

    public function kecamatanList() {
        return Kecamatan::all();
    }

    public function openModalDownload() {
        $this->openModal($this->idModal);
    }

    public function next() {
        $this->openModal('modal-konfigurasi-laporan');
    }

    public function download() {
        if ($this->tipe_laporan === 'petani') {
            $this->id_kecamatan = $this->id_kecamatan ?? 0;
            return redirect()->route('print-laporan.petani', ['id' => $this->id_kecamatan]);
        } elseif($this->tipe_laporan === 'penyuluh') {
            $this->id_kecamatan = $this->id_tanaman ?? 0;
            return redirect()->route('print-laporan.ahli-pertanian', ['id' => $this->id_tanaman]);
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

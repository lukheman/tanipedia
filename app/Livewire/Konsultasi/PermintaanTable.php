<?php

namespace App\Livewire\Konsultasi;

use App\Models\Konsultasi;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Enums\StatusKonsultasi;

#[Title('Permintaan Konsultasi')]
class PermintaanTable extends Component
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
                    ->where('status', StatusKonsultasi::PENDING)
; }
        })->get();

    }

    public function accepted($id)
    {
        $konsultasi = Konsultasi::query()->findOrFail($id);
        $konsultasi->accept();
        $this->notifySuccess('Konsultasi berhasil diterima.');
    }

    public function rejected($id)
    {
        $konsultasi = Konsultasi::query()->findOrFail($id);
        $konsultasi->reject();
        $this->notifySuccess('Konsultasi berhasil ditolak.');
    }

    public function delete($id) {
        $konsultasi = Konsultasi::query()->findOrFail($id);
        $konsultasi->delete();
        $this->notifySuccess('Konsultasi berhasil dihapus.');

    }

    public function render()
    {
        return view('livewire.konsultasi.permintaan-table');
    }
}

<?php

namespace App\Livewire;

use App\Livewire\Forms\JadwalPenyuluhanForm;
use App\Models\JadwalPenyuluhan;
use App\Traits\Traits\WithModal;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanJadwalPenyuluhanTable extends Component
{
    use WithModal;
    use WithPagination;

    public JadwalPenyuluhanForm $form;

    #[Computed]
    public function jadwalPenyuluhan() {
        $jadwalPenyuluhan = JadwalPenyuluhan::with('desa', 'penyuluh')->paginate(10);

        return $jadwalPenyuluhan;

    }

    public function detail($id)
    {
        $jadwal = JadwalPenyuluhan::with(['desa'])->findOrFail($id);
        $this->form->fillFromModel($jadwal);
        $this->openModal('modal-show-jadwal');

    }

    public function render()
    {
        return view('livewire.laporan-jadwal-penyuluhan-table');
    }
}

<?php

namespace App\Livewire;

use App\Enums\State;
use App\Enums\StatusJadwal;
use App\Livewire\Forms\JadwalPenyuluhanForm;
use App\Models\Desa;
use App\Models\JadwalPenyuluhan;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class JadwalPenyuluhanTable extends Component
{
    use WithModal;
    use WithNotify;

    public JadwalPenyuluhanForm $form;

    public $currentState = State::CREATE;
    public $idModal = 'modal-form-jadwal-penyuluhan';

    public function add()
    {
        $this->currentState = State::CREATE;
        $this->form->reset();
        $this->openModal($this->idModal);
    }


    #[On('openDetailJadwal')]
    public function openDetailJadwal($id)
    {
        $this->detail($id);
        $this->currentState = State::UPDATE;
    }

    public function detail($id)
    {
        $this->currentState = State::SHOW;

        $jadwal = JadwalPenyuluhan::with(['desa'])->findOrFail($id);
        $this->form->fillFromModel($jadwal);

        if (auth('penyuluh')->check()) {

            $this->openModal('modal-form-jadwal-penyuluhan');
        } else if(auth('petani')->check()) {
            $this->openModal('modal-show-jadwal');
        }

    }

    public function edit($id)
    {
        $this->detail($id);
        $this->currentState = State::UPDATE;
    }

    public function save()

    {
        $this->form->id_penyuluh = getActiveUserId();
            if ($this->currentState === State::CREATE) {
                $this->form->store();
                $this->notifySuccess('Berhasil menambahkan jadwal penyuluhan.');
            } elseif ($this->currentState === State::UPDATE) {
                $this->form->update();
                $this->notifySuccess('Berhasil memperbarui jadwal penyuluhan.');
            }

            $this->closeModal($this->idModal);

            // Emit event untuk refresh kalender di browser
            $this->dispatch('refreshCalendar', events: $this->getCalendarEvents());

    }

    public function delete($id)
    {
        $jadwal = JadwalPenyuluhan::findOrFail($id);
        $this->form->fillFromModel($jadwal);

        $this->dispatch('deleteConfirmation', message: 'Apakah Anda yakin ingin menghapus jadwal penyuluhan ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        try {
            $this->form->delete();
            $this->notifySuccess('Berhasil menghapus jadwal penyuluhan.');

            // Update kalender setelah penghapusan
            $this->dispatch('refreshCalendar', events: $this->getCalendarEvents());

        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }

    #[Computed]
    public function desaList() {

        $user = getActiveUser();

        $user->load('desa', 'desa.kecamatan');

        return Desa::query()->where('id_kecamatan', $user->desa->kecamatan->id_kecamatan)->get();
    }



    #[Computed]
    public function jadwalList()
    {
        // Untuk tampilan tabel (jika kamu punya)
        return JadwalPenyuluhan::query()
            ->with(['penyuluh', 'desa'])
            ->orderByDesc('tanggal')
            ->get();
    }

    /**
     * Buat event untuk FullCalendar (dipanggil di JS via @json)
     */
    public function getCalendarEvents(): array
    {
        // Ambil semua jadwal (tanpa pagination)
        $jadwals = JadwalPenyuluhan::with('desa')->orderBy('tanggal')->get();

        return $jadwals->map(function ($item) {
            $defaultColor = '#6c757d'; // abu-abu

            return [
                'id' => $item->id_jadwal_penyuluhan,
                'title' => ($item->desa->nama ?? '-') . ' - ' . ($item->kegiatan ?? ''),
                'start' => $item->tanggal,
                'color' => match ($item->status) {
                    StatusJadwal::DIJADWALKAN => '#007bff', // biru (primary)
                    StatusJadwal::SELESAI => '#28a745',     // hijau (success)
                    StatusJadwal::DIBATALKAN => '#dc3545',  // merah (danger)
                    StatusJadwal::DIUNDUR => '#ffc107',     // kuning (warning)
                    default => $defaultColor,
                },
            ];
        })->values()->all();
    }

    public function render()
    {
        return view('livewire.jadwal-penyuluhan-table');
    }
}

<?php

namespace App\Livewire;

use App\Enums\State;
use App\Enums\StatusJadwal;
use App\Livewire\Forms\JadwalPenyuluhanForm;
use App\Models\Desa;
use App\Models\JadwalPenyuluhan;
use App\Models\Kecamatan;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use function getActiveUser;

class JadwalPenyuluhanTable extends Component
{
    use WithModal;
    use WithNotify;

    public JadwalPenyuluhanForm $form;

    public $currentState = State::CREATE;
    public $idModal = 'modal-form-jadwal-penyuluhan';

    public $kecamatanList;
    public $desaList;

    public $kecamatan;

    public function add()
    {
        $this->currentState = State::CREATE;
        $this->form->reset();
        $this->openModal($this->idModal);
    }

    public function mount()
    {
        $this->kecamatanList = Kecamatan::all();
        $this->desaList = collect(); // Initialize as empty

    }

    public function updatedKecamatan($value)
    {
        $this->desaList = $value ? Desa::where('id_kecamatan', $value)->get() : collect();
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

        $jadwal = JadwalPenyuluhan::with('desa', 'desa.kecamatan')->findOrFail($id);

        $this->kecamatan = $jadwal->desa->kecamatan->id_kecamatan;
        $this->updatedKecamatan($this->kecamatan);

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

    /**
     * Buat event untuk FullCalendar (dipanggil di JS via @json)
     */
    public function getCalendarEvents(): array
    {
        $user = getActiveUser();
        $user->load('desa');

        $query = JadwalPenyuluhan::query()->with('desa');

        if (auth('petani')->check()) {
            $query->where('id_desa', $user->desa->id_desa);
        } elseif (auth('penyuluh')->check()) {
            $query->where('id_penyuluh', $user->id_penyuluh);
        }

        $jadwals = $query->orderBy('tanggal')->get();

        return $jadwals->map(function ($item) {
            $defaultColor = '#6c757d'; // abu-abu

            return [
                'id' => $item->id_jadwal_penyuluhan,
                'title' => sprintf('%s - %s', $item->desa->nama ?? '-', $item->kegiatan ?? ''),
                'start' => $item->tanggal,
                'color' => match ($item->status) {
                    StatusJadwal::DIJADWALKAN => '#007bff', // biru
                    StatusJadwal::SELESAI     => '#28a745', // hijau
                    StatusJadwal::DIBATALKAN  => '#dc3545', // merah
                    StatusJadwal::DIUNDUR     => '#ffc107', // kuning
                    default                   => $defaultColor,
                },
            ];
        })->values()->all();
    }

    public function render()
    {
        return view('livewire.jadwal-penyuluhan-table');
    }
}

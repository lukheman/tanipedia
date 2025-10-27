<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\PenyuluhForm;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

use function getActiveUser;

#[Title('Profile Penyuluh')]
class PenyuluhProfile extends Component
{
    use WithFileUploads;
    use WithNotify;

    public PenyuluhForm $form;

    public $user;
    public $kecamatanList;
    public $desaList;
    public $kecamatan;

    public function mount()
    {
        $user = getActiveUser(); // ambil penyuluh yang sedang login
        $user->load('desa', 'desa.kecamatan');

        $this->user = $user;
        $this->form->fillFromModel($user);

        // Ambil semua data kecamatan untuk dropdown
        $this->kecamatanList = Kecamatan::all();

        // Set kecamatan & desa awal berdasarkan data user
        $this->kecamatan = $user->desa->kecamatan->id_kecamatan;
        $this->desaList = Desa::where('id_kecamatan', $this->kecamatan)->get();
    }

    public function edit()
    {
        $this->form->update();
        $this->notifySuccess('Berhasil menyimpan perubahan profil penyuluh.');
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = Desa::where('id_kecamatan', $value)->get();
        $this->form->id_desa = null; // reset desa ketika kecamatan diganti
    }

    public function render()
    {
        return view('livewire.profile.penyuluh-profile');
    }
}

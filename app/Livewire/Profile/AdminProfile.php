<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\AdminForm;
use App\Models\Admin;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

use function getActiveUser;

#[Title('Profile Admin')]
class AdminProfile extends Component
{
    use WithFileUploads;
    use WithNotify;

    public AdminForm $form;

    public $user;
    public $kecamatanList;
    public $desaList;
    public $kecamatan;

    public function mount()
    {
        $user = getActiveUser(); // ambil admin yang sedang login
        $user->load('desa', 'desa.kecamatan');

        $this->user = $user;
        $this->form->fillFromModel($user);

        // data relasi kecamatan & desa
        $this->kecamatanList = Kecamatan::all();
        $this->kecamatan = $user->desa->kecamatan->id_kecamatan ?? '';
        $this->desaList = Desa::where('id_kecamatan', $this->kecamatan)->get();
    }

    public function edit()
    {
        $this->form->update();
        $this->notifySuccess('Berhasil menyimpan perubahan profil admin.');
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = Desa::where('id_kecamatan', $value)->get();
        $this->form->desa = null; // reset desa saat kecamatan diganti
    }

    public function render()
    {
        return view('livewire.profile.admin-profile');
    }
}

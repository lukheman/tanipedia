<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\KepalaDinasForm;
use App\Models\KepalaDinas;
use App\Models\Kecamatan;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

use function getActiveUser;

#[Title('Profile Kepala Dinas')]
class KepalaDinasProfile extends Component
{
    use WithFileUploads;
    use WithNotify;

    public KepalaDinasForm $form;

    public $user;
    public $kecamatanList;
    public $kecamatan;

    public function mount()
    {
        $user = getActiveUser(); // ambil kepala dinas yang sedang login

        $this->user = $user;
        $this->form->fillFromModel($user);
    }

    public function edit()
    {
        $this->form->update();
        $this->notifySuccess('Berhasil menyimpan perubahan profil kepala dinas.');
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = Desa::where('id_kecamatan', $value)->get();
        $this->form->desa = null; // reset desa saat kecamatan diganti
    }

    public function render()
    {
        return view('livewire.profile.kepala-dinas-profile');
    }
}

<?php

namespace App\Livewire\Profile;

use App\Livewire\Forms\PetaniForm;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

use function getActiveUser;

#[Title('Profile Petani')]
class PetaniProfile extends Component
{
    use WithFileUploads;
    use WithNotify;

    public PetaniForm $form;

    public $user;
    public $kecamatanList;
    public $desaList;
    public $kecamatan;

    public function mount()
    {
        $user = getActiveUser(); // ambil petani yang sedang login
        $user->load('desa', 'desa.kecamatan');


        $this->user = $user;
        $this->form->fillFromModel($user);

        // Ambil semua data kecamatan untuk dropdown
        $this->kecamatanList = Kecamatan::all();

        // Set kecamatan & desa awal berdasarkan data user
        $this->kecamatan = optional($user->desa?->kecamatan)->id_kecamatan;
        $this->desaList = $this->kecamatan
            ? Desa::where('id_kecamatan', $this->kecamatan)->get()
            : collect();
    }

    public function edit()
    {
        $this->form->update();
        $this->notifySuccess('Berhasil menyimpan perubahan profil petani.');
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = Desa::where('id_kecamatan', $value)->get();
        $this->form->id_desa = null; // reset desa ketika kecamatan diganti
    }

    public function render()
    {
        return view('livewire.profile.petani-profile');
    }
}

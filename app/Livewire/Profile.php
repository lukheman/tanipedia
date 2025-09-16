<?php

namespace App\Livewire;

use App\Livewire\Forms\ProfileForm;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

use function getActiveGuard;

#[Title('Profile')]
class Profile extends Component
{
    use WithFileUploads;
    use WithNotify;

    public ProfileForm $form;

    public $user;

    public $kecamatanList;

    public $desaList;

    public $kecamatan;

    public function edit()
    {
        if ($this->form->update()) {

            $this->notifySuccess('Berhasil menyimpan perubahan profile');
        }

    }

    // Listen for changes to kecamatan and update desaList
    public function updatedKecamatan($value)
    {
        $this->desaList = Desa::where('id_kecamatan', $value)->get();
        $this->form->desa = null; // Reset desa selection when kecamatan changes
    }

    public function mount()
    {

        $guard = getActiveGuard();
        $this->user = Auth::guard($guard)->user(); // guard aktif

        $this->form->user = $this->user;

        $this->form->name = $this->user->name ?? '';
        $this->form->email = $this->user->email ?? '';
        $this->form->tanggal_lahir = $this->user->tanggal_lahir ?? '';
        $this->form->telepon = $this->user->telepon ?? '';
        $this->form->desa = $this->user->desa->id ?? '';
        $this->kecamatan = $this->user->desa->id_kecamatan ?? '';

        $this->desaList = Desa::where('id_kecamatan', $this->kecamatan)->get();

        $this->kecamatanList = Kecamatan::all();

    }

    public function render()
    {
        return view('livewire.profile');
    }
}

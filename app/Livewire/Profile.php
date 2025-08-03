<?php

namespace App\Livewire;

use App\Livewire\Forms\ProfileForm;
use App\Models\User;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Profile')]
class Profile extends Component
{
    use WithFileUploads;
    use WithNotify;

    public ProfileForm $form;

    public User $user;

    public function edit()
    {
        if ($this->form->update()) {

            $this->notifySuccess('Berhasil menyimpan perubahan profile');
        }

    }

    public function mount()
    {

        $this->user = auth()->user();

        $this->form->name = $this->user->name;
        $this->form->email = $this->user->email;
        $this->form->tanggal_lahir = $this->user->tanggal_lahir;
        $this->form->telepon = $this->user->telepon;

    }

    public function render()
    {
        return view('livewire.profile');
    }
}

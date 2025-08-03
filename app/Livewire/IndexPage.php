<?php

namespace App\Livewire;

use App\Traits\WithNotify;
use Livewire\Component;

class IndexPage extends Component
{
    use WithNotify;

    public function notif()
    {

        $this->notifySuccess('Berhasil memperbarui gejala ke penyakit');
        $this->dispatch('deleteConfirmation', message: 'trest');

    }

    public function render()
    {
        return view('livewire.index-page');
    }
}

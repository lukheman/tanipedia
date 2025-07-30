<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\WithNotify;

class IndexPage extends Component
{

    use WithNotify;

    public function notif() {

        $this->notifySuccess('Berhasil memperbarui gejala ke penyakit');
        $this->dispatch('deleteConfirmation', message: "trest");

    }

    public function render()
    {
        return view('livewire.index-page');
    }
}

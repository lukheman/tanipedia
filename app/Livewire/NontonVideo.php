<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class NontonVideo extends Component
{
    public $video;

    public $new_komentar;

    public ?string $redirect;

    public function mount($id)
    {
        $this->redirect = request()->query('redirect');
        $this->video = Edukasi::with(['user', 'komentar', 'komentar.user'])->find($id);
    }

    public function saveKomentar()
    {

        $this->video->komentar()->create([
            'isi' => $this->new_komentar,
            'id_user' => auth()->user()->id,
            'tanggal_komentar' => date('Y-m-d'),
        ]);

        $this->reset('new_komentar');

    }

    public function render()
    {
        return view('livewire.nonton-video');
    }
}

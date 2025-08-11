<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class BacaBerita extends Component
{
    public $berita;

    public ?string $redirect = null;

    public function mount($id)
    {
        $this->berita = Berita::with('penulis')->find($id);
        // $this->redirect = request()->query('redirect');
        $this->redirect = route('berita.index');
    }

    public function render()
    {
        return view('livewire.baca-berita');
    }
}

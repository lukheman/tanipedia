<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class BacaBerita extends Component
{
    public $berita;

    public function mount($id)
    {
        $this->berita = Berita::with('penulis')->find($id);
    }

    public function render()
    {
        return view('livewire.baca-berita');
    }
}

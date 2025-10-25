<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use Livewire\Component;

class BeritaCard extends Component
{
    public Berita $berita;

    public function render()
    {
        return view('livewire.berita.berita-card');
    }
}

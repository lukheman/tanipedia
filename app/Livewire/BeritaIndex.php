<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class BeritaIndex extends Component
{
    public function render()
    {
        return view('livewire.berita-index', [
            'berita' => Berita::all(),
        ]);
    }
}

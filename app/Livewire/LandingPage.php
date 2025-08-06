<?php

namespace App\Livewire;

use App\Models\Berita;
use App\Models\Edukasi;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class LandingPage extends Component
{
    public function render()
    {
        return view('livewire.landing-page', [
            'berita' => Berita::limit(3)->latest()->get(),
            'videos' => Edukasi::limit(3)->latest()->get(),
        ]);
    }
}

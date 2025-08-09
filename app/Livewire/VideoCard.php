<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Livewire\Component;

class VideoCard extends Component
{
    public Edukasi $video;

    public function render()
    {
        return view('livewire.video-card');
    }
}

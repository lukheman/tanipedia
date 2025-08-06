<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class VideoIndex extends Component
{

    public string $search = '';

    #[Computed]
    public function videos() {
        return Edukasi::query()
            ->when($this->search, function($query) {
                $query->where('judul', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->get() ;
    }

    public function render()
    {
        return view('livewire.video-index');
    }
}

<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Livewire\Component;
use Livewire\WithPagination;

class ListVideoTable extends Component
{
    use WithPagination;

    public function edit($video)
    {
        $this->dispatch('editVideo', $video);
        $this->dispatch('setState', 'add');
    }

    public function render()
    {
        return view('livewire.list-video-table', [
            'videos' => Edukasi::paginate(5),
        ]);
    }
}

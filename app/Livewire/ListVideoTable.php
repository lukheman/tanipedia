<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Livewire\Component;
use Livewire\WithPagination;

class ListVideoTable extends Component
{
    use WithPagination;

    public function edit($id_video)
    {
        $this->dispatch('editVideo', $id_video);
        $this->dispatch('setState', 'add');
    }

    public function render()
    {
        return view('livewire.list-video-table', [
            'videos' => Edukasi::paginate(5),
        ]);
    }
}

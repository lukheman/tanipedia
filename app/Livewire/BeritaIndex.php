<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class BeritaIndex extends Component
{
    public string $search = '';

    #[Computed]
    public function berita()
    {
        return Berita::query()
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->get();

    }

    public function render()
    {
        return view('livewire.berita-index');
    }
}

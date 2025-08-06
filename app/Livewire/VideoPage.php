<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\Edukasi;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Galeri Video')]
class VideoPage extends Component
{
    use WithNotify;
    use WithPagination;

    public $selectedVideo = null;

    public State $currentState = State::LISTDATA;

    public $selectedIdVideo;

    #[On('setState')]
    public function setState($state)
    {
        $this->currentState = State::from($state);
    }

    public function edit($video)
    {
        $this->currentState = State::UPDATE;
        $this->selectedVideo = $video;
    }

    public function komentar($video)
    {
        $this->currentState = State::KOMENTAR;
        $this->selectedVideo = $video;
    }

    public function delete(int $id)
    {
        $this->selectedIdVideo = $id;
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus video edukasi ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $video = Edukasi::find($this->selectedIdVideo);

        if (Storage::disk('public')->exists($video->url_video)) {
            Storage::disk('public')->delete($video->url_video);
        }

        $video->delete();
        $this->notifySuccess('Berhasil menghapus video edukasi');
    }

    public function render()
    {

        return view('livewire.video-page', [
            'videos' => \App\Models\Edukasi::latest()->paginate(5),
        ]);
    }
}

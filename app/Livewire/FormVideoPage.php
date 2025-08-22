<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\Edukasi;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormVideoPage extends Component
{
    use WithFileUploads;
    use WithNotify;

    public $judul;

    public $deskripsi;

    public $url_video;

    public $selectedId;

    public State $currentState = State::CREATE;

    public $video;

    public function save()
    {

        if ($this->currentState === State::CREATE) {
            $this->validate([
                'judul' => 'required|string|min:3|max:255',
                'deskripsi' => 'string|min:3|max:255',
                'video' => 'required|file|mimes:mp4,avi,mpeg,mov|max:102400',
            ]);
            try {
                // Simpan video ke storage
                $path = $this->video->store('videos', 'public');

                Edukasi::create([
                    'id_user' => Auth::guard('admin')->user()->id_admin,
                    'judul' => $this->judul,
                    'tanggal_publikasi' => date('Y-m-d'),
                    'deskripsi' => $this->deskripsi,
                    'url_video' => $path,
                ]);

                $this->dispatch('setState', state: State::LISTDATA->value);

                $this->notifySuccess('Berhasil menambahkan video');
                $this->reset();

            } catch (\Exception $e) {
                $this->notifyError('Gagal upload video: '.$e->getMessage());
            }

        } elseif ($this->currentState === State::UPDATE) {
            $this->validate([
                'judul' => 'required|string|min:3|max:255',
                'deskripsi' => 'string|min:3|max:255',
            ]);

            try {
                $edukasi = Edukasi::findOrFail($this->selectedId);

                $edukasi->update([
                    'judul' => $this->judul,
                    'deskripsi' => $this->deskripsi,
                    'tanggal_publikasi' => date('Y-m-d'),
                ]);

                $this->dispatch('setState', state: State::LISTDATA->value);
                $this->notifySuccess('Berhasil memperbarui video');

            } catch (\Exception $e) {
                $this->notifyError('Gagal memperbarui video: '.$e->getMessage());
            }
        }
    }

    public function mount($video = null)
    {
        if ($video) {
            $this->currentState = State::UPDATE;
            $this->judul = $video['judul'];
            $this->deskripsi = $video['deskripsi'];
            $this->url_video = $video['url_video'];
            $this->selectedId = $video['id_video'];
        }
    }

    public function render()
    {
        return view('livewire.form-video-page');
    }
}

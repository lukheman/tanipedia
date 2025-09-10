<?php

namespace App\Livewire;

use App\Enums\State;
use App\Livewire\Forms\VideoForm;
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

    public VideoForm $form;

    public $uploadProgress = 0;

    public State $currentState = State::CREATE;

    public $video;

    public function save()
    {

        if ($this->currentState === State::CREATE) {
            try {
                $this->form->store();

                $this->dispatch('setState', state: State::LISTDATA->value);

                $this->notifySuccess('Berhasil menambahkan video');
                $this->reset();

            } catch (\Exception $e) {
                $this->notifyError('Gagal upload video: '.$e->getMessage());
            }

        } elseif ($this->currentState === State::UPDATE) {

            try {

                $this->form->update();

                $this->dispatch('setState', state: State::LISTDATA->value);
                $this->notifySuccess('Berhasil memperbarui video');

            } catch (\Exception $e) {
                $this->notifyError('Gagal memperbarui video: '.$e->getMessage());
            }
        }
    }

    public function mount($id_video = null)
    {
        if ($id_video) {

            $edukasi = Edukasi::find($id_video);
            $this->currentState = State::UPDATE;
            $this->form->fillFromModel($edukasi);

        }
    }

    public function render()
    {
        return view('livewire.form-video-page');
    }
}

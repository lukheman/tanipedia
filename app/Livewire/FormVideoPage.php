<?php

namespace App\Livewire;

use App\Enums\State;
use App\Livewire\Forms\VideoForm;
use App\Models\Edukasi;
use App\Traits\WithNotify;
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
                $this->form->store();

                $this->dispatch('setState', state: State::LISTDATA->value);

                $this->notifySuccess('Berhasil menambahkan video');
                $this->reset();

        } elseif ($this->currentState === State::UPDATE) {


                $this->form->update();

                $this->dispatch('setState', state: State::LISTDATA->value);
                $this->notifySuccess('Berhasil memperbarui video');

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

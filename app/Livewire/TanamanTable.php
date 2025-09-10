<?php

namespace App\Livewire;

use App\Enums\State;
use App\Livewire\Forms\TanamanForm;
use App\Models\Tanaman;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TanamanTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;


    public TanamanForm $form;

    public $currentState = State::CREATE;

    public $idModal = 'modal-form-tanaman';

    public function detail($id) {
        $this->currentState = State::SHOW;

        $tanaman = Tanaman::findOrFail($id);

        $this->form->fillFromModel($tanaman);
        $this->openModal($this->idModal);
    }

    public function edit($id) {
        $this->detail($id);
        $this->currentState = State::UPDATE;
    }

    public function save() {
        if($this->currentState == State::CREATE) {
            $this->form->store();
            $this->notifySuccess('Berhasil menambahkan data tanaman');
        } else if($this->currentState == State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Berhasil memperbarui data tanaman');
        }

        $this->closeModal($this->idModal);

    }

    public function delete($id) {
        $tanaman = Tanaman::findOrFail($id);
        $this->form->fillFromModel($tanaman);
        $this->dispatch('deleteConfirmation', message: 'Apakah Anda yakin ingin menghapus data tanaman ini?',);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed() {
        try {
            $this->form->delete();
            $this->notifySuccess('Berhasil menghapus data tanaman');
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus data tanaman: '.$e->getMessage());
        }
    }

    public function add() {
        $this->currentState = State::CREATE;
        $this->form->reset();
        $this->openModal($this->idModal);
    }


    #[Computed]
    public function tanamanList() {
        return Tanaman::query()->orderBy('nama')->paginate(10);
    }

    public function render()
    {
        return view('livewire.tanaman-table');
    }
}

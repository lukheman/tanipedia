<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\User;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Forms\UserForm;

#[Title('Manajemen Pengguna')]
class PenggunaPage extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public UserForm $form;

    public $currentState = State::CREATE;

    public $idModal = 'modal-form-pengguna';

    public $kecamatanList;

    public $desaList;

    public $selectedDesa;

    public $selectedKecamatan;

    public $kecamatan;

    public function mount()
    {
        $this->kecamatanList = Kecamatan::all();
        $this->desaList = collect(); // Initialize as empty
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = $value ? Desa::where('id_kecamatan', $value)->get() : collect();
    }

    public function detail($id)
    {
        $user = User::with('desa')->find($id);
        $this->currentState = State::SHOW;
        $this->form->user = $user;
        $this->form->name = $user->name;
        $this->form->email = $user->email;
        $this->form->alamat = $user->alamat;
        $this->form->role = $user->role;
        $this->form->telepon = $user->telepon;
        $this->form->tanggal_lahir = $user->tanggal_lahir;
        $this->form->id_desa = $user->desa->id ?? null;
        $this->kecamatan = $user->desa->id_kecamatan;
        $this->selectedDesa = $user->desa->nama;
        $this->selectedKecamatan = Kecamatan::find($user->desa->id_kecamatan)->nama;
        $this->updatedKecamatan($this->kecamatan); // Load desa list for the selected kecamatan
        $this->openModal($this->idModal);

    }

    public function edit($id)
    {
        $this->detail($id);
        $this->currentState = State::UPDATE;
    }

    public function save()
    {

        if ($this->currentState === State::CREATE) {
            $this->form->store();
            $this->notifySuccess('Pengguna berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Pengguna berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);

    }

    public function delete(int $id)
    {
        $this->form->user = User::findOrFail($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus pengguna ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        try {
            $this->form->delete();
            $this->notifySuccess('Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus pengguna: '.$e->getMessage());
        }
    }

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function render()
    {
        return view('livewire.pengguna-page', [
            'users' => User::with('desa')->latest()->paginate(10),
        ]);
    }
}

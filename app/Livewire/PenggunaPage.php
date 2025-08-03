<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\User;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen Pengguna')]
class PenggunaPage extends Component
{
    use WithNotify;
    use WithPagination;

    #[Validate('required|string|max:255', message: 'Nama wajib diisi dan maksimal 255 karakter.')]
    public $name = '';

    #[Validate('required|email|max:255|unique:users,email', message: 'Email wajib diisi, harus valid, dan belum terdaftar.')]
    public $email = '';

    #[Validate('required', message: 'Role wajib dipilih (admin atau user).')]
    public $role = '';

    #[Validate('required|string|regex:/^0[0-9]{9,14}$/', message: 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.')]
    public $telepon = '';

    #[Validate('required|date|before:today', message: 'Tanggal lahir wajib diisi dan harus sebelum hari ini.')]
    public $tanggal_lahir = '';

    public $selectedIdUser;

    public $currentState = State::CREATE;

    public function edit($user)
    {
        $this->currentState = State::UPDATE;

        // isi form
        $this->detail($user);
    }

    public function detail($user)
    {
        $this->currentState = State::SHOW;
        $this->selectedIdUser = $user['id'];
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->role = $user['role'];
        $this->telepon = $user['telepon'];
        $this->tanggal_lahir = $user['tanggal_lahir'];
    }

    public function save()
    {
        if ($this->currentState === State::CREATE) {
            $this->validate();

            try {
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'telepon' => $this->telepon,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'password' => bcrypt('password123'),
                ]);

                $this->notifySuccess('Pengguna berhasil ditambahkan!');
                $this->reset(['name', 'email', 'role', 'telepon', 'tanggal_lahir']);
            } catch (\Exception $e) {
                $this->notifyError('Gagal menambahkan pengguna: '.$e->getMessage());
            }

        } elseif ($this->currentState === State::UPDATE) {

            try {

                $this->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email,'.$this->selectedIdUser,
                    'role' => 'required',
                    'telepon' => 'required|string|regex:/^0[0-9]{9,14}$/|unique:users,telepon,'.$this->selectedIdUser,
                    'tanggal_lahir' => 'required|date|before:today',
                ]);

                $user = User::findOrFail($this->selectedIdUser);

                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'telepon' => $this->telepon,
                    'tanggal_lahir' => $this->tanggal_lahir,
                ]);

                $this->notifySuccess('Berhasil memperbarui pengguna');

            } catch (\Exception $e) {
                $this->notifyError('Gagal memperbarui pengguna: '.$e->getMessage());
            }
        }

    }

    public function delete(int $id)
    {
        $this->selectedIdUser = $id;
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus pengguna ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        try {
            $user = User::findOrFail($this->selectedIdUser);
            $user->delete();
            $this->notifySuccess('Pengguna berhasil dihapus!');
            $this->reset('selectedIdUser');
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus pengguna: '.$e->getMessage());
        }
    }

    public function clearForm()
    {
        $this->reset(['name', 'email', 'role', 'telepon', 'tanggal_lahir']);
    }

    public function render()
    {
        return view('livewire.pengguna-page', [
            'users' => User::paginate(10),
        ]);
    }
}

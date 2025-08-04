<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\User;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen Pengguna')]
class PenggunaPage extends Component
{
    use WithNotify;
    use WithPagination;
    use WithModal;

    public $name = '';
    public $email = '';
    public $role = '';
    public $telepon = '';
    public $tanggal_lahir = '';

    public $selectedIdUser;

    public $currentState = State::CREATE;

    public $idModal = 'modal-form-pengguna';


    public function edit($user)
    {
        $this->currentState = State::UPDATE;
        $this->detail($user);
        $this->openModal($this->idModal);
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
            // Validasi untuk mode CREATE
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'role' => 'required',
                'telepon' => 'required|string',
                'tanggal_lahir' => 'required|date|before:today',
            ], [
                'name.required' => 'Nama wajib diisi dan maksimal 255 karakter.',
                'name.string' => 'Nama wajib diisi dan maksimal 255 karakter.',
                'name.max' => 'Nama wajib diisi dan maksimal 255 karakter.',
                'email.required' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'email.email' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'email.max' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'email.unique' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'role.required' => 'Role wajib dipilih (admin atau user).',
                'telepon.required' => 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
                'tanggal_lahir.required' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
                'tanggal_lahir.date' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
                'tanggal_lahir.before' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            ]);

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
                $this->notifyError('Gagal menambahkan pengguna: ' . $e->getMessage());
            }
        } elseif ($this->currentState === State::UPDATE) {
            // Validasi untuk mode UPDATE
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $this->selectedIdUser,
                'role' => 'required',
                'telepon' => 'required|string|regex:/^0[0-9]{9,14}$/|unique:users,telepon,' . $this->selectedIdUser,
                'tanggal_lahir' => 'required|date|before:today',
            ], [
                'name.required' => 'Nama wajib diisi dan maksimal 255 karakter.',
                'name.string' => 'Nama wajib diisi dan maksimal 255 karakter.',
                'name.max' => 'Nama wajib diisi dan maksimal 255 karakter.',
                'email.required' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'email.email' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'email.max' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'email.unique' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
                'role.required' => 'Role wajib dipilih (admin atau user).',
                'telepon.required' => 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
                'telepon.string' => 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
                'telepon.regex' => 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
                'telepon.unique' => 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
                'tanggal_lahir.required' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
                'tanggal_lahir.date' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
                'tanggal_lahir.before' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            ]);

            try {
                $user = User::findOrFail($this->selectedIdUser);

                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'telepon' => $this->telepon,
                    'tanggal_lahir' => $this->tanggal_lahir,
                ]);

                $this->notifySuccess('Berhasil memperbarui pengguna');
                $this->closeModal();
            } catch (\Exception $e) {
                $this->notifyError('Gagal memperbarui pengguna: ' . $e->getMessage());
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
            $this->notifyError('Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    public function add() {
        $this->currentState = State::CREATE;
        $this->clearForm();
        $this->openModal($this->idModal);
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

<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\User;
use App\Models\Desa;
use App\Models\Kecamatan;
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
    public $alamat = '';
    public $kecamatan = '';
    public $desa = '';

    public $selectedIdUser;
    public $currentState = State::CREATE;
    public $idModal = 'modal-form-pengguna';
    public $kecamatanList;
    public $desaList;

    public $selectedDesa;
    public $selectedKecamatan;

    public function mount()
    {
        $this->kecamatanList = Kecamatan::all();
        $this->desaList = collect(); // Initialize as empty
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = $value ? Desa::where('id_kecamatan', $value)->get() : collect();
    }

    public function detail($user)
    {
        $this->currentState = State::SHOW;
        $this->selectedIdUser = $user['id'];
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->alamat = $user['alamat'];
        $this->role = $user['role'];
        $this->telepon = $user['telepon'];
        $this->tanggal_lahir = $user['tanggal_lahir'];
        $this->desa = $user['desa']['id'] ?? null;
        $this->kecamatan = $user['desa']['id_kecamatan'];
        $this->selectedDesa = Desa::find($user['desa']['id'])->nama;
        $this->selectedKecamatan = Kecamatan::find($user['desa']['id_kecamatan'])->nama;
        $this->updatedKecamatan($this->kecamatan); // Load desa list for the selected kecamatan
        $this->openModal($this->idModal);

    }

    public function edit($user)
    {
        $this->detail($user);
        $this->currentState = State::UPDATE;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'alamat' => 'required|max:255',
            'role' => 'required',
            'telepon' => 'required|string|regex:/^0[0-9]{9,14}$/',
            'tanggal_lahir' => 'required|date|before:today',
            'desa' => 'required|exists:desa,id',
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi dan maksimal 255 karakter.',
            'name.string' => 'Nama wajib diisi dan maksimal 255 karakter.',
            'name.max' => 'Nama wajib diisi dan maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
            'email.email' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
            'email.max' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'role.required' => 'Role wajib dipilih.',
            'telepon.required' => 'Telepon wajib diisi dan harus berupa nomor Indonesia (0xxxxxxxxxx).',
            'telepon.regex' => 'Telepon harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            'tanggal_lahir.date' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            'tanggal_lahir.before' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            'desa.required' => 'Desa wajib dipilih.',
            'desa.exists' => 'Desa yang dipilih tidak valid.',
        ];

        if ($this->currentState === State::CREATE) {
            $rules['email'] .= '|unique:users,email';
            $rules['telepon'] .= '|unique:users,telepon';
        } elseif ($this->currentState === State::UPDATE) {
            $rules['email'] .= '|unique:users,email,' . $this->selectedIdUser;
            $rules['telepon'] .= '|unique:users,telepon,' . $this->selectedIdUser;
        }

        $this->validate($rules, $messages);

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'alamat' => $this->alamat,
                'role' => $this->role,
                'telepon' => $this->telepon,
                'tanggal_lahir' => $this->tanggal_lahir,
                'id_desa' => $this->desa,
            ];

            if ($this->currentState === State::CREATE) {
                $data['password'] = bcrypt('password123');
                User::create($data);
                $this->notifySuccess('Pengguna berhasil ditambahkan!');
                $this->clearForm();
            } elseif ($this->currentState === State::UPDATE) {
                $user = User::findOrFail($this->selectedIdUser);
                $user->update($data);
                $this->notifySuccess('Pengguna berhasil diperbarui!');
            }

            $this->closeModal($this->idModal);
        } catch (\Exception $e) {
            $this->notifyError('Gagal menyimpan pengguna: ' . $e->getMessage());
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

    public function add()
    {
        $this->currentState = State::CREATE;
        $this->clearForm();
        $this->openModal($this->idModal);
    }

    public function clearForm()
    {
        $this->reset(['name', 'email', 'alamat', 'role', 'telepon', 'tanggal_lahir', 'kecamatan', 'desa']);
        $this->desaList = collect(); // Reset desa list
    }

    public function render()
    {
        return view('livewire.pengguna-page', [
            'users' => User::with('desa')->paginate(10),
        ]);
    }
}

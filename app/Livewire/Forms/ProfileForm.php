<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class ProfileForm extends Form
{
    use WithFileUploads;

    #[Validate('required|string|max:255', message: 'Nama wajib diisi dan maksimal 255 karakter.')]
    public $name;

    #[Validate('required|email|max:255|unique:users,email', message: 'Email wajib diisi, harus valid, dan belum terdaftar.', onUpdate: false)]
    public $email;

    #[Validate('required|string|regex:/^0[0-9]{9,14}$/', message: 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.')]
    public $telepon;

    #[Validate('required|date|before:today', message: 'Tanggal lahir wajib diisi dan harus sebelum hari ini.')]
    public $tanggal_lahir;

    #[Validate('nullable|string', message: 'Alamat wajib di isi')]
    public $alamat;

    #[Validate(['nullable', 'min:4'], onUpdate: false)]
    public string $password = '';

    #[Validate('nullable|image|max:2048', message: 'Foto harus berupa gambar dengan ukuran maksimal 2MB.')]
    public $photo;

    #[Validate('required|exists:desa,id', message: 'Desa tidak boleh kosong')]
    public $desa;

    public function update(): bool
    {
        // Get the authenticated user
        $user = auth()->user();
        if (! $user instanceof User) {
            $this->addError('general', 'User not found.');

            return false;
        }

        // Validate the form data
        $validated = $this->validate([
            'name' => ['required', 'max:50'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'desa' => 'required|exists:desa,id',
            'alamat' => 'required',
            'password' => ['nullable', 'min:4'],
            'telepon' => ['nullable', 'required', 'string', 'regex:/^0[0-9]{9,14}$/'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        // Prepare updates only for changed fields
        $updates = [];
        if ($this->name !== $user->name) {
            $updates['name'] = $this->name;
        }
        if ($this->email !== $user->email) {
            $updates['email'] = $this->email;
        }
        if (! empty($this->password)) {
            $updates['password'] = Hash::make($this->password);
        }
        if ($this->telepon !== $user->telepon) {
            $updates['telepon'] = $this->telepon;
        }
        if ($this->tanggal_lahir !== $user->tanggal_lahir) {
            $updates['tanggal_lahir'] = $this->tanggal_lahir;
        }
        if ($this->desa !== $user->id_desa) {
            $updates['id_desa'] = $this->desa;
        }
        if ($this->alamat !== $user->alamat) {
            $updates['alamat'] = $this->alamat;
        }

        if ($this->photo) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Store new photo
            $path = $this->photo->store('photos', 'public');
            $updates['photo'] = $path;
        }

        // Perform update only if there are changes
        if (! empty($updates)) {
            $user->update($updates);

            return true;
        }

        return false; // No changes made
    }
}

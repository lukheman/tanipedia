<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class PetaniForm extends Form
{
    use WithFileUploads;

    public ?User $petani = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $telepon = '';
    public string $tanggal_lahir = '';
    public $photo = null; // bisa string path atau file upload
    public $id_desa = null;

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => [
                'required',
                'email',
                Rule::unique('petani', 'email')->ignore($this->petani),
            ],
            'password'      => ['nullable', 'string', 'min:8'],
            'telepon'       => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'photo'         => ['nullable', 'image', 'max:2048'],
            'id_desa'       => ['nullable', 'exists:desa,id_desa'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.min'           => 'Password minimal 8 karakter.',
            'telepon.required'       => 'Nomor telepon wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'   => 'Tanggal lahir tidak boleh di masa depan.',
            'photo.image'            => 'File harus berupa gambar.',
            'photo.max'              => 'Ukuran foto maksimal 2MB.',
            'id_desa.exists'         => 'Desa tidak ditemukan.',
        ];
    }

    public function store()
    {
        $data = $this->validate();

        $data['password'] = Hash::make($data['password']);

        if ($this->photo) {
            $path = $this->photo->store('photos', 'public');
            $data['photo'] = $path;
        }

        User::create($data);

        $this->reset();
    }

    public function update()
    {
        $data = $this->validate();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($this->photo) {
            if ($this->petani->photo) {
                Storage::disk('public')->delete($this->petani->photo);
            }

            $path = $this->photo->store('photos', 'public');
            $data['photo'] = $path;
        }

        $this->petani->update($data);
    }

    public function delete()
    {
        if ($this->petani->photo) {
            Storage::disk('public')->delete($this->petani->photo);
        }

        $this->petani->delete();
    }

    public function fillFromModel(User $petani): void
    {
        $this->petani = $petani;
        $this->name = $petani->name;
        $this->email = $petani->email;
        $this->telepon = $petani->telepon;
        $this->tanggal_lahir = $petani->tanggal_lahir;
        $this->id_desa = $petani->id_desa;
        $this->photo = $petani->photo;
    }
}

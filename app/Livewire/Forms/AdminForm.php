<?php

namespace App\Livewire\Forms;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class AdminForm extends Form
{
    use WithFileUploads;

    public ?Admin $admin = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $telepon = '';
    public string $tanggal_lahir = '';
    public $photo = null; // bisa berupa string path atau file upload

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => [
                'required',
                'email',
                Rule::unique('admin', 'email')->ignore($this->admin),
            ],
            'password'      => ['required', 'string', 'min:8'],
            'telepon'       => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'photo'         => ['nullable', 'image', 'max:2048'], // max 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal terdiri dari 8 karakter.',
            'telepon.required'       => 'Nomor telepon wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'   => 'Tanggal lahir tidak boleh di masa depan.',
            'photo.image'            => 'File yang diunggah harus berupa gambar.',
            'photo.max'              => 'Ukuran foto maksimal 2MB.',
        ];
    }

    public function store()
    {
        $data = $this->validate();

        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Simpan foto jika ada
        if ($this->photo) {
            $path = $this->photo->store('photos', 'public');
            $data['photo'] = $path;
        }

        Admin::create($data);

        $this->reset();
    }

    public function update()
    {
        $data = $this->validate();

        // Update password hanya jika diisi
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Update foto jika diunggah baru
        if ($this->photo) {
            // Hapus foto lama jika ada
            if ($this->admin->photo) {
                Storage::disk('public')->delete($this->admin->photo);
            }

            $path = $this->photo->store('photos', 'public');
            $data['photo'] = $path;
        }

        $this->admin->update($data);

    }

    public function delete()
    {
        if ($this->admin->photo) {
            Storage::disk('public')->delete($this->admin->photo);
        }

        $this->admin->delete();
    }

    public function fillFromModel(Admin $admin): void
    {
        $this->admin = $admin;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->telepon = $admin->telepon;
        $this->tanggal_lahir = $admin->tanggal_lahir;
        $this->photo = $admin->photo;
    }

}

<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use function getActiveGuard;
use function str_replace;
use function strtolower;

class ProfileForm extends Form
{
    use WithFileUploads;

    public $name;

    public $email;

    public $telepon;

    public $tanggal_lahir;

    public $alamat;

    public string $password = '';

    public $photo;

    public $desa;

    public $user;

    protected function rules(): array
    {

        $guard = getActiveGuard(); // guard / table active

        return [
            'name' => ['required', 'max:50'],
            'email' => [
                'required',
                'email',
                Rule::unique($guard, 'email')->ignore($this->user),
            ],
            'desa' => 'required|exists:desa,id_desa',
            'alamat' => 'required|max:255',
            'password' => ['nullable', 'min:4'],
            'telepon' => [
                'required',
                'regex:/^0[0-9]{9,14}$/',
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
            ],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Mohon masukkan nama Anda (maksimal 255 karakter).',
            'name.string' => 'Nama hanya boleh berisi huruf atau karakter yang valid.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Mohon masukkan email Anda.',
            'email.email' => 'Format email tidak valid, silakan periksa kembali.',

            'alamat.required' => 'Mohon isi alamat Anda.',
            'alamat.max' => 'Alamat maksimal 255 karakter',

            'telepon.required' => 'Mohon masukkan nomor telepon Anda.',
            'telepon.regex' => 'Nomor telepon harus format Indonesia, diawali 0, dan panjang 10–15 digit.',

            'tanggal_lahir.required' => 'Mohon masukkan tanggal lahir Anda.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',

            'id_desa.required' => 'Silakan pilih desa.',
            'id_desa.exists' => 'Desa yang dipilih tidak tersedia di sistem.',
        ];
    }

    public function update(): bool
    {
        // Validate the form data
        $this->validate();

        // Prepare updates only for changed fields
        $updates = [];
        if ($this->name !== $this->user->name) {
            $updates['name'] = $this->name;
        }
        if ($this->email !== $this->user->email) {
            $updates['email'] = $this->email;
        }
        if (! empty($this->password)) {
            $updates['password'] = Hash::make($this->password);
        }
        if ($this->telepon !== $this->user->telepon) {
            $updates['telepon'] = $this->telepon;
        }
        if ($this->tanggal_lahir !== $this->user->tanggal_lahir) {
            $updates['tanggal_lahir'] = $this->tanggal_lahir;
        }
        if ($this->desa !== $this->user->id_desa) {
            $updates['id_desa'] = $this->desa;
        }
        if ($this->alamat !== $this->user->alamat) {
            $updates['alamat'] = $this->alamat;
        }

        if ($this->photo) {
            // Delete old photo if exists
            if ($this->user->photo) {
                Storage::disk('public')->delete($this->user->photo);
            }
            // Store new photo
            $path = $this->photo->store('photos', 'public');
            $updates['photo'] = $path;
        }

        // Perform update only if there are changes
        if (! empty($updates)) {
            $this->user->update($updates);

            return true;
        }

        return false; // No changes made
    }
}

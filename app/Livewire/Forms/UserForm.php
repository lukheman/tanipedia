<?php

namespace App\Livewire\Forms;

use App\Enums\Role;
use App\Models\Admin;
use App\Models\KepalaDinas;
use App\Models\Penyuluh;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public $user;

    public $name = '';

    public $email = '';

    public $telepon = '';

    public $tanggal_lahir = '';

    public $alamat = '';

    public ?int $id_desa;

    public $type;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique(str_replace(' ', '_', strtolower($this->type)), 'email')->ignore($this->user),

            ],
            'telepon' => [
                'required',
                'regex:/^0[0-9]{9,14}$/',
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
            ],
            'alamat' => 'required|max:255',
            'id_desa' => 'required|exists:desa,id_desa',
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

    public function store()
    {
        $type = Role::from($this->type);

        if ($type === Role::PETANI) {
            User::create($this->validate());
        } elseif ($type === Role::ADMIN) {
            Admin::create($this->validate());
        } elseif ($type === Role::AHLIPERTANIAN) {
            Penyuluh::create($this->validate());
        } elseif ($type === Role::KEPALADINAS) {
            KepalaDinas::create($this->validate());
        }

        $this->reset();
    }

    public function update()
    {
        $this->user->update($this->validate());
        $this->reset();
    }

    public function delete()
    {
        $this->user->delete();
        $this->reset();
    }
}

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


    public ?int $id_desa;

    public $type;

    public ?int $id_tanaman;

    protected function rules(): array
    {
        $rules = [
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
        ];

        // hanya penyuluh yang punya id_tanaman
        if ($this->type === Role::AHLIPERTANIAN->value) {
            $rules['id_tanaman'] = 'required|exists:tanaman,id_tanaman';
        }

        if ($this->type === Role::PETANI->value || $this->type === Role::AHLIPERTANIAN->value) {

            $rules['id_desa'] = 'required|exists:desa,id_desa';

        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Mohon masukkan nama Anda (maksimal 255 karakter).',
            'name.string' => 'Nama hanya boleh berisi huruf atau karakter yang valid.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Mohon masukkan email Anda.',
            'email.email' => 'Format email tidak valid, silakan periksa kembali.',

            'telepon.required' => 'Mohon masukkan nomor telepon Anda.',
            'telepon.regex' => 'Nomor telepon harus format Indonesia, diawali 0, dan panjang 10–15 digit.',

            'tanggal_lahir.required' => 'Mohon masukkan tanggal lahir Anda.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',

            'id_desa.required' => 'Silakan pilih desa.',
            'id_desa.exists' => 'Desa yang dipilih tidak tersedia di sistem.',

            'id_tanaman.required' => 'Silakan pilih tanaman.',
            'id_tanaman.exists' => 'Tanaman yang dipilih tidak tersedia di sistem.',
        ];
    }

    public function store()
    {
        $this->validate();

        $type = Role::from($this->type);

        if ($type === Role::PETANI) {
            User::create($validated);
        } elseif ($type === Role::ADMIN) {
            Admin::create($validated);
        } elseif ($type === Role::AHLIPERTANIAN) {
            Penyuluh::create($validated); // sudah ada id_tanaman di $validated
        } elseif ($type === Role::KEPALADINAS) {
            KepalaDinas::create($validated);
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

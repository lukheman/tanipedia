<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.guest')]
class RegistrasiPage extends Component
{
    #[Validate('required|string|max:255', message: 'Nama wajib diisi dan maksimal 255 karakter.')]
    public $name;

    #[Validate('required|email|max:255|unique:users,email', message: 'Email wajib diisi, harus valid, dan belum terdaftar.')]
    public $email;

    #[Validate('required|string|regex:/^0[0-9]{9,14}$/', message: 'Telepon wajib diisi dan harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.')]
    public $telepon;

    #[Validate('nullable|string', message: 'Alamat wajib di isi')]
    public $alamat;

    #[Validate('required|date|before:today', message: 'Tanggal lahir wajib diisi dan harus sebelum hari ini.')]
    public $tanggal_lahir;

    #[Rule('required|string|min:4|confirmed')]
    public $password;

    #[Rule('required|exists:desa,id')]
    public $desa;

    public $password_confirmation;

    public $kecamatanList;
    public $desaList;

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

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'tanggal_lahir' => $this->tanggal_lahir,
            'id_desa' => $this->desa,
            'alamat' => $this->alamat,
            'role' => Role::PETANI->value,
            'password' => bcrypt($this->password),
        ]);

        session()->flash('message', 'Registrasi berhasil! Silakan login.');
        $this->redirectRoute('login');
    }

    public function render()
    {
        return view('livewire.registrasi-page');
    }
}

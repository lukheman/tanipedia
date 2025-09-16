<?php

namespace App\Livewire;

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
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email|max:255|unique:petani,email', message: 'Email wajib diisi, harus valid, dan belum terdaftar.')]
    public $email;

    #[Validate('required|string|regex:/^0[0-9]{9,14}$/|unique:petani,telepon')]
    public $telepon;

    #[Validate('required|date|before:today')]
    public $tanggal_lahir;

    #[Rule('required|string|min:4|confirmed')]
    public $password;

    #[Rule('required|exists:desa,id_desa')]
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

    public function messages(): array
    {

        return [
            'name.required' => 'Nama wajib diisi dan maksimal 255 karakter.',
            'name.string' => 'Nama wajib diisi dan maksimal 255 karakter.',
            'name.max' => 'Nama wajib diisi dan maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
            'email.email' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
            'email.max' => 'Email wajib diisi, harus valid, dan belum terdaftar.',
            'email.unique' => 'Email telah terdaftar',
            'telepon.required' => 'Telepon wajib diisi dan harus berupa nomor Indonesia (0xxxxxxxxxx).',
            'telepon.regex' => 'Telepon harus berupa nomor Indonesia yang dimulai dari 0 dengan panjang 10 hingga 15 digit.',
            'telepon.unique' => 'Nomor telepon telah terdaftar',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            'tanggal_lahir.date' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            'tanggal_lahir.before' => 'Tanggal lahir wajib diisi dan harus sebelum hari ini.',
            'desa.required' => 'Desa wajib dipilih.',
            'desa.exists' => 'Desa yang dipilih tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai dengan password yang dimasukkan.',
        ];
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

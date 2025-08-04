<?php

namespace App\Livewire;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use function request;

#[Layout('layouts.guest')]
class LoginPage extends Component
{
    #[Rule(['required', 'email', 'exists:users,email'])]
    public string $email = '';

    #[Rule(['required'])]
    public string $password = '';

    public ?string $redirect = null;

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus di isi',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password harus di isi',
        ];
    }

    public function mount() {
        $this->redirect = request()->query('redirect');
    }

    public function submit()
    {
        if (Auth::attempt($this->validate())) {
            $role = Role::from(Auth::user()->role);

            // Cek apakah ada parameter redirect
             $redirectUrl = $this->redirect ?? route('dashboard');

            match (Role::from(Auth::user()->role)) {
                Role::ADMIN,
                Role::PETANI,
                Role::AHLIPERTANIAN,
                Role::KEPALADINAS => redirect()->to($redirectUrl), // Redirect ke URL yang disimpan
                default => flash('Email tidak terdaftar atau password tidak valid', 'danger')
            };
        }

        flash('Password tidak valid', 'danger');
    }

    public function render()
    {
        return view('livewire.login-page');
    }
}

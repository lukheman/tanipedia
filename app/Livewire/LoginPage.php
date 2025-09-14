<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.guest')]
class LoginPage extends Component
{
    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required'])]
    public string $password = '';

    public ?string $redirect = null;

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ];
    }

    public function mount()
    {
        $this->redirect = request()->query('redirect');
    }

    public function submit()
    {
        $credentials = $this->validate();

        foreach (['admin', 'petani', 'penyuluh', 'kepala_dinas'] as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {

                // regenerate session agar tidak session fixation
                Auth::guard($guard)->login(Auth::guard($guard)->user(), true);

                if($guard === 'petani') {

                    if ($this->redirect === route('konsultasi')) {
                        if ($guard !== 'petani') {
                            Auth::guard($guard)->logout();
                            flash('Silakan login sebagai petani untuk melakukan konsultasi.', 'danger');

                            return;
                        }

                        flash('Berhasil login sebagai petani');
                        return redirect()->route('konsultasi');
                    }
                    return redirect()->route('petani-home');
                }

                // khusus redirect konsultasi → hanya petani yg boleh login

                flash('Berhasil login sebagai '.$guard);

                return redirect()->intended($this->redirect ?? route('dashboard'));
            }
        }

        return flash('Email atau password tidak valid.', 'danger');
    }

    public function render()
    {
        return view('livewire.login-page');
    }
}

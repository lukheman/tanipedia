<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use function getActiveGuard;

#[Layout('layouts.guest')]
class NontonVideo extends Component
{
    public ?Edukasi $video;

    public $new_komentar;

    public ?string $redirect;

    public function mount($id)
    {
        $this->redirect = route('video.index');
        $this->video = Edukasi::with(['user', 'komentar', 'komentar.user'])->find($id);
    }

    public function saveKomentar()
    {
        $guard = getActiveGuard();
        $user = Auth::guard($guard)->user();

        $this->video->komentar()->create([
            'isi' => $this->new_komentar,
            'id_user' => $user->id,
            'tanggal_komentar' => date('Y-m-d'),
        ]);

        $this->reset('new_komentar');
        flash('Terima kasih, komentar Anda sudah berhasil dikirim.');

    }

    public function render()
    {
        return view('livewire.nonton-video');
    }
}

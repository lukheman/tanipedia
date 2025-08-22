<?php

namespace App\Livewire;

use App\Models\Komentar;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Komentar Video')]
class KomentarPage extends Component
{
    use WithNotify;
    use WithPagination;

    public $komentar;

    public $selectedIdKomentar;

    public function mount($id)
    {
        $this->komentar = Komentar::with('user')->where('id_video', $id)->get();
    }

    public function delete(int $id)
    {
        $this->selectedIdKomentar = $id;
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus komentar ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        Komentar::destroy($this->selectedIdKomentar);
        $this->notifySuccess('Berhasil menghapus komentar');

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.komentar-page');
    }
}

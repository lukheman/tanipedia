<?php

namespace App\Livewire;

use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Berita;
use Livewire\WithPagination;

#[Title('Berita')]
class BeritaPage extends Component
{

    use WithPagination;
    use WithNotify;

    public ?int $selectedIdBerita;
    public $isi = '';
    public $judul = '';
    public $tanggal_publikasi = '';

    public function submit() {
        $this->
        dd($this->isi, $this->judul);
    }

    public function delete(int $id) {
        $this->selectedIdBerita = $id;
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed() {
        Berita::destroy($this->selectedIdBerita);
        $this->notifySuccess('Berhasil menghapus berita');
    }

    public function render()
    {

        return view('livewire.berita-page', [
            'berita' => Berita::with('penulis')->paginate(3)
        ]);
    }
}

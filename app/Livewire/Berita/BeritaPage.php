<?php

namespace App\Livewire\Berita;

use App\Enums\State;
use App\Models\Berita;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Artikel & Berita')]
class BeritaPage extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public ?int $selectedIdBerita;

    public $isi = '';

    public $judul = '';

    public $tanggal_publikasi = '';

    public $currentState = State::LISTDATA;

    public string $idModal = 'modal-show-berita';

    public function edit($id)
    {
        return redirect()->route('berita.edit', ['id' => $id]);
    }

    #[On('setState')]
    public function setState($state)
    {
        $state = State::from($state);
        if ($state === State::CREATE) {
            $this->dispatch('initEditor');
        }

        $this->currentState = $state;
    }

    // public function update($berita) {
    //     $this->dispatch('updateBerita', berita: $berita);
    // }

    public function detail($item)
    {
        $this->selectedIdBerita = $item['id_berita'];
        $this->isi = $item['isi'];
        $this->judul = $item['judul'];
        $this->tanggal_publikasi = $item['tanggal_publikasi'];
        $this->openModal($this->idModal);
    }

    public function delete(int $id)
    {
        $this->selectedIdBerita = $id;
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        Berita::destroy($this->selectedIdBerita);
        $this->notifySuccess('Berhasil menghapus berita');
    }

    public function render()
    {

        return view('livewire.berita.berita-page', [
            'berita' => Berita::with('penulis')->latest()->paginate(5),
        ]);
    }
}

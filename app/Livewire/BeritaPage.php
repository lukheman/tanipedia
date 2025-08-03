<?php

namespace App\Livewire;

use App\Enums\State;
use App\Models\Berita;
use App\Traits\WithNotify;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Artikel & Berita')]
class BeritaPage extends Component
{
    use WithNotify;
    use WithPagination;

    public ?int $selectedIdBerita;

    public $isi = '';

    public $judul = '';

    public $tanggal_publikasi = '';

    public $currentState = State::LISTDATA;

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
        $this->selectedIdBerita = $item['id'];
        $this->isi = $item['isi'];
        $this->judul = $item['judul'];
        $this->tanggal_publikasi = $item['tanggal_publikasi'];
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

        return view('livewire.berita-page', [
            'berita' => Berita::with('penulis')->paginate(3),
        ]);
    }
}

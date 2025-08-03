<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;

class FormBeritaPage extends Component
{
    public ?int $selectedIdBerita = null;

    public $isi = '';

    public $judul = '';

    public $isEditMode = false;

    public $berita;

    public function mount($id = null)
    {
        if ($id) {
            $this->berita = Berita::findOrFail($id);
            $this->selectedIdBerita = $id;
            $this->judul = $this->berita->judul;
            $this->isi = $this->berita->isi;
            $this->isEditMode = true;
        }
    }

    public function submit()
    {
        $this->validate([
            'judul' => 'required|min:3|max:255|unique:berita,judul,'.($this->selectedIdBerita ?? 'NULL'),
            'isi' => 'required|min:3|max:10000',
        ]);

        if ($this->isEditMode && $this->selectedIdBerita) {
            // Update berita
            Berita::find($this->selectedIdBerita)->update([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'tanggal_publikasi' => date('Y-m-d'),
                'id_user' => auth()->id(),
            ]);
            session()->flash('message', 'Berita berhasil diperbarui!');
        } else {
            // Buat berita baru
            Berita::create([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'tanggal_publikasi' => date('Y-m-d'),
                'id_user' => auth()->id(),
            ]);
            session()->flash('message', 'Berita berhasil ditambahkan!');
        }

        return redirect()->route('berita');
    }

    public function render()
    {
        return view('livewire.form-berita-page');
    }
}

<?php

namespace App\Livewire;

use App\Models\Berita;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Artikel & Berita')]
class FormBeritaPage extends Component
{
    use WithFileUploads;
    use WithNotify;

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

        $this->validate(
            [
                'judul' => [
                    'required',
                    'min:3',
                    'max:255',
                    Rule::unique('berita', 'judul')->ignore($this->selectedIdBerita ?? null, 'id_berita'),
                ],
                'isi' => 'required|min:10|max:10000',
            ], [
                'judul.required' => 'Judul tidak boleh kosong',
                'judul.min' => 'Judul minimal 3 karakter',
                'judul.max' => 'Judul maksimal 255 karakter',
                'judul.unique' => 'Judul telah digunakan',
                'isi.required' => 'Isi berita tidak boleh kosong',
                'isi.min' => 'Isi minimal 3 karakter',
                'isi.max' => 'Isi maksimal 10000 karakter',
            ]);

        if ($this->isEditMode && $this->selectedIdBerita) {
            // Update berita
            Berita::find($this->selectedIdBerita)->update([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'tanggal_publikasi' => date('Y-m-d'),
                'id_penulis' => Auth::guard('admin')->user()->id_admin,
            ]);
            $this->notifySuccess('Berita berhasil diperbarui', reload: true);
        } else {
            // Buat berita baru
            Berita::create([
                'judul' => $this->judul,
                'isi' => $this->isi,
                'tanggal_publikasi' => date('Y-m-d'),
                'id_penulis' => Auth::guard('admin')->user()->id_admin,
            ]);
            $this->notifySuccess(message: 'Berita berhasil ditambahkan', reload: true);
        }

        return redirect()->route('berita');

    }

    public function render()
    {
        return view('livewire.form-berita-page');
    }
}

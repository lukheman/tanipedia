<?php

namespace App\Livewire\Forms;

use App\Models\Edukasi;
use Livewire\Form;

class VideoForm extends Form
{
    public ?Edukasi $edukasi = null;

    public $judul;

    public $deskripsi;

    public $url_video;

    public $video;

    protected function rules(): array
    {
        return [
            'judul' => 'required|string|min:3|max:255',
            'deskripsi' => 'nullable',
            'video' => 'nullable|file|mimes:mp4,avi,mpeg,mov|max:512000',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul wajib diisi',
            'judul.min' => 'Judul minimal 3 karakter',
            'judul.max' => 'Judul maksimal 255 karakter',
            'video.required' => 'Video wajib diisi',
            'video.mimes' => 'Format video harus mp4, avi, mpeg, atau mov',
            'video.max' => 'Ukuran video maksimal 100MB',
        ];
    }

    public function store()
    {
        $this->validate();

        // Simpan video ke storage
        $path = $this->video->store('videos', 'public');

        Edukasi::create([
            'id_admin' => auth()->guard('admin')->user()->id_admin,
            'judul' => $this->judul,
            'tanggal_publikasi' => date('Y-m-d'),
            'deskripsi' => $this->deskripsi,
            'url_video' => $path,
        ]);

        $this->reset();
    }

    public function update()
    {

        $this->edukasi->update([
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal_publikasi' => date('Y-m-d'),
        ]);

        $this->reset();
    }

    public function fillFromModel(Edukasi $edukasi)
    {
        $this->edukasi = $edukasi;
        $this->judul = $edukasi->judul;
        $this->deskripsi = $edukasi->deskripsi;
        $this->url_video = $edukasi->url_video;
    }
}

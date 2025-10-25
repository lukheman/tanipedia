<?php

namespace App\Livewire\Forms;

use App\Models\Pesan;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class PesanForm extends Form
{
    use WithFileUploads;

    public ?Pesan $pesan = null;

    public ?int $id_konsultasi = null;
    public ?int $id_pengirim = null;
    public ?string $role_pengirim = null;
    public string $isi = '';
    public $gambar = null; // untuk file upload

    protected function rules(): array
    {
        return [
            'id_konsultasi' => ['required', 'exists:konsultasi,id_konsultasi'],
            'id_pengirim' => ['required', 'integer'],
            'role_pengirim' => ['required', 'string'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:2048'], // opsional
        ];
    }

    protected function messages(): array
    {
        return [
            'id_konsultasi.required' => 'Konsultasi wajib diisi.',
            'id_konsultasi.exists' => 'Konsultasi tidak ditemukan.',
            'id_pengirim.required' => 'ID pengirim wajib diisi.',
            'role_pengirim.required' => 'Role pengirim wajib diisi.',
            'isi.string' => 'Isi pesan harus berupa teks.',
            'isi.required' => 'Pesan tidak boleh kosong',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    public function store()
    {
        $data = $this->validate();


        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('pesan', 'public');
        }

        Pesan::query()->create($data);
        $this->reset(['isi', 'gambar']);
    }

    public function update()
    {
        $this->validate();

        if ($this->pesan) {
            $data = [
                'isi' => $this->isi,
                'role_pengirim' => $this->role_pengirim,
            ];

            if ($this->gambar) {
                $data['gambar'] = $this->gambar->store('pesan', 'public');
            }

            $this->pesan->update($data);
        }
    }

    public function delete()
    {
        if ($this->pesan) {
            $this->pesan->delete();
            $this->reset();
        }
    }

    public function fillFromModel(Pesan $pesan)
    {
        $this->pesan = $pesan;
        $this->id_konsultasi = $pesan->id_konsultasi;
        $this->id_pengirim = $pesan->id_pengirim;
        $this->role_pengirim = $pesan->role_pengirim;
        $this->isi = $pesan->isi;
        $this->gambar = $pesan->gambar;
    }
}

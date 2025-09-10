<?php

namespace App\Livewire\Forms;

use App\Models\Tanaman;
use Illuminate\Validation\Rule;
use Livewire\Form;

class TanamanForm extends Form
{
    public ?Tanaman $tanaman = null;

    public string $nama = '';

    protected function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255', Rule::unique('tanaman', 'nama')->ignore($this->tanaman)],
        ];
    }

    protected function messages(): array
    {
        return [
            'nama.required' => 'Nama tanaman harus diisi.',
            'nama.string' => 'Nama tanaman harus berupa teks.',
            'nama.max' => 'Nama tanaman tidak boleh lebih dari 255 karakter.',
            'nama.unique' => 'Nama tanaman sudah ada.',
        ];
    }

    public function store()
    {
        $this->validate();

        Tanaman::query()->create([
            'nama' => $this->nama,
        ]);

        $this->reset();

    }

    public function update()
    {
        $this->validate();
        $this->tanaman->update([
            'nama' => $this->nama,
        ]);

    }

    public function delete()
    {
        $this->tanaman->delete();
        $this->reset();
    }

    public function fillFromModel(Tanaman $tanaman)
    {
        $this->tanaman = $tanaman;
        $this->nama = $tanaman->nama;
    }
}

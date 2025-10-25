<?php

namespace App\Livewire\Forms;

use App\Enums\StatusJadwal;
use App\Models\JadwalPenyuluhan;
use Illuminate\Validation\Rule;
use Livewire\Form;

class JadwalPenyuluhanForm extends Form
{
    public ?JadwalPenyuluhan $jadwal = null;

    public ?int $id_penyuluh = null;
    public ?int $id_desa = null;
    public ?string $tanggal = null;
    public ?string $kegiatan = null;
    public ?string $laporan = null;
    public ?string $status = 'terjadwal';

    protected function rules(): array
    {
        return [
            'id_penyuluh' => ['required', 'exists:penyuluh,id_penyuluh'],
            'id_desa' => ['required', 'exists:desa,id_desa'],
            'tanggal' => ['required', 'date'],
            'kegiatan' => ['nullable', 'string'],
            'laporan' => ['nullable', 'string'],
            'status' => ['required', Rule::in(StatusJadwal::values())],
        ];
    }

    protected function messages(): array
    {
        return [
            'id_penyuluh.required' => 'Penyuluh harus dipilih.',
            'id_penyuluh.exists' => 'Penyuluh tidak valid.',
            'id_desa.required' => 'Desa harus dipilih.',
            'id_desa.exists' => 'Desa tidak valid.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'status.required' => 'Status jadwal harus diisi.',
            'status.in' => 'Status jadwal tidak valid.',
        ];
    }

    public function store()
    {
        $this->validate();

        // JadwalPenyuluhan::query()->create([
        //     'id_penyuluh' => $this->id_penyuluh,
        //     'id_desa' => $this->id_desa,
        //     'tanggal' => $this->tanggal,
        //     'kegiatan' => $this->kegiatan,
        //     'laporan' => $this->laporan,
        //     'status' => $this->status,
        // ]);

        JadwalPenyuluhan::query()->create($this->validate());

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        // $this->jadwal->update([
        //     'id_penyuluh' => $this->id_penyuluh,
        //     'id_desa' => $this->id_desa,
        //     'tanggal' => $this->tanggal,
        //     'kegiatan' => $this->kegiatan,
        //     'laporan' => $this->laporan,
        //     'status' => $this->status,
        // ]);

        $this->jadwal->update($this->validate());
        $this->reset();

    }

    public function delete()
    {
        $this->jadwal?->delete();
        $this->reset();
    }

    public function fillFromModel(JadwalPenyuluhan $jadwal)
    {
        $this->jadwal = $jadwal;
        $this->id_penyuluh = $jadwal->id_penyuluh;
        $this->id_desa = $jadwal->id_desa;
        $this->tanggal = $jadwal->tanggal;
        $this->kegiatan = $jadwal->kegiatan ?? '';
        $this->laporan = $jadwal->laporan ?? '';
        $this->status = $jadwal->status->value;
    }
}

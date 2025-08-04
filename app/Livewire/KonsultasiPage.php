<?php

namespace App\Livewire;

use App\Models\HasilKonsultasi;
use App\Models\Konsultasi;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Enums\Role;

#[Title('Daftar Konsultasi')]
class KonsultasiPage extends Component
{
    use WithNotify;
    use WithModal;

    public $selectedIdKonsultasi;

    public $nama_petani = '';

    public $nama_ahli_pertanian = '';

    public $isi = '';

    public $tanggal_konsultasi = '';

    public $nama_tanaman = '';

    #[Validate('required|string|max:2000', message: 'Jawaban wajib diisi dan maksimal 2000 karakter.')]
    public $jawaban;

    public function detail($konsultasi)
    {
        $this->selectedIKonsultasi = $konsultasi['id'];
        $this->nama_petani = $konsultasi['user']['name'];
        $this->isi = $konsultasi['isi'];
        $this->nama_tanaman = $konsultasi['nama_tanaman'];
        $this->tanggal_konsultasi = $konsultasi['tanggal_konsultasi'];

        $konsultasi = Konsultasi::with('hasil', 'hasil.user')->find($konsultasi['id']);
        if ($konsultasi->hasil) {
            $this->nama_ahli_pertanian = $konsultasi->hasil->user->name;
            $this->jawaban = $konsultasi->hasil->isi;
        }

        $this->openModal('modal-detail-konsultasi');

    }

    public function jawab($id)
    {
        $this->selectedIdKonsultasi = $id;
        $konsultasi = Konsultasi::with('hasil')->find($id);
        if ($konsultasi->hasil) {
            $this->jawaban = $konsultasi->hasil->isi;
        }
        $this->openModal('modal-jawab');
    }

    public function kirimJawaban()
    {
        $this->validateOnly('jawaban');

        try {
            $konsultasi = Konsultasi::with('hasil')->find($this->selectedIdKonsultasi);

            if ($konsultasi->hasil) {

                $konsultasi->hasil->update([
                    'isi' => $this->jawaban,
                ]);
                $konsultasi->hasil->save();
                $this->notifySuccess('Berhasil memperbarui jawaban');

                return;
            }

            $hasil_konsultasi = HasilKonsultasi::create([
                'id_user' => auth()->user()->id,
                'isi' => $this->jawaban,
            ]);

            $konsultasi->update([
                'id_solusi' => $hasil_konsultasi->id,
            ]);

            $konsultasi->save();

            $this->notifySuccess('Jawaban berhasil dikirim!');
            $this->reset(['jawaban', 'selectedIdKonsultasi']);
        } catch (\Exception $e) {
            $this->notifyError('Gagal mengirim konsultasi: '.$e->getMessage());
        }
    }

    public function delete(int $id)
    {
        $this->selectedIdKonsultasi = $id;
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        try {
            $konsultasi = Konsultasi::findOrFail($this->selectedIdKonsultasi);

            // Optional: Check if the authenticated user owns the consultation
            if ($konsultasi->id_user !== Auth::id()) {
                $this->notifyError('Anda tidak memiliki izin untuk menghapus konsultasi ini.');
            }

            $konsultasi->delete(); // Deletes Konsultasi and its HasilKonsultasi (via cascadeOnDelete)

            $this->notifySuccess('Konsultasi berhasil dihapus!');
            $this->reset(['selectedIdKonsultasi']);
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus konsultasi: '.$e->getMessage());
        }
    }

    public function render()
    {
    if (auth()->user()->role === Role::PETANI->value) {
        $konsultasi = Konsultasi::with('user')
            ->where('id_user', auth()->id())
            ->get();
    } else {
        $konsultasi = Konsultasi::with('user')->get();
    }

    return view('livewire.konsultasi-page', [
        'konsultasi' => $konsultasi,
    ]);
}
}

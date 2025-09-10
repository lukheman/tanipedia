<?php

namespace App\Livewire;

use App\Models\Desa;
use App\Models\HasilKonsultasi;
use App\Models\Konsultasi;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

use function getActiveGuard;

#[Title('Daftar Konsultasi')]
class KonsultasiTable extends Component
{
    use WithModal;
    use WithNotify;

    public $selectedIdKonsultasi;

    public $nama_petani = '';

    public $nama_ahli_pertanian = '';

    public $isi = '';

    public $tanggal_konsultasi = '';

    public $nama_tanaman = '';

    #[Validate('required|string|max:2000', message: 'Jawaban wajib diisi dan maksimal 2000 karakter.')]
    public $jawaban;

    public function detail($id)
    {
        $konsultasi = Konsultasi::query()->with(['hasil', 'hasil.user'])->findOrFail($id);

        $this->selectedIdKonsultasi = $konsultasi['id_konsultasi'];
        $this->nama_petani = $konsultasi->user->name;
        $this->isi = $konsultasi->isi;
        $this->nama_tanaman = $konsultasi->tanaman->nama;
        $this->tanggal_konsultasi = $konsultasi->tanggal_konsultasi;

        if ($konsultasi && $konsultasi->hasil) {
            $this->nama_ahli_pertanian = $konsultasi->hasil->user->name;
            $this->jawaban = $konsultasi->hasil->isi;
        }

        $this->openModal('modal-detail-konsultasi');
    }

    public function jawab($id)
    {
        $this->selectedIdKonsultasi = $id;

        $k = Konsultasi::with('hasil')->find($id);
        $this->jawaban = $k->hasil->isi ?? '';
        $this->openModal('modal-jawab');
    }

    public function kirimJawaban()
    {
        $this->validateOnly('jawaban');

        try {
            $k = Konsultasi::with(['hasil'])->find($this->selectedIdKonsultasi);

            if ($k->hasil) {
                $k->hasil->update([
                    'isi' => $this->jawaban,
                ]);
                $this->notifySuccess('Berhasil memperbarui jawaban');

                return;
            }

            $hasil = HasilKonsultasi::create([
                'id_penyuluh' => Auth::guard('penyuluh')->user()->id_penyuluh, // otomatis ambil user id sesuai guard aktif
                'isi' => $this->jawaban,
            ]);

            $k->update([
                'id_solusi' => $hasil->id_solusi,
            ]);

            $this->notifySuccess('Jawaban berhasil dikirim!');
            $this->reset(['jawaban', 'selectedIdKonsultasi']);
        } catch (\Exception $e) {
            $this->notifyError('Gagal mengirim jawaban: '.$e->getMessage());
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
            $k = Konsultasi::findOrFail($this->selectedIdKonsultasi);
            $k->delete();

            $this->notifySuccess('Konsultasi berhasil dihapus!');
            $this->reset(['selectedIdKonsultasi']);
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus konsultasi: '.$e->getMessage());
        }
    }

    public function render()
    {
        $guard = getActiveGuard(); // guard aktif
        $user = Auth::guard($guard)->user();

        if ($guard === 'petani') {
            $konsultasi = Konsultasi::with('user')
                ->where('id_petani', $user->id_petani)
                ->get();

        } elseif ($guard === 'penyuluh') {
            // penyuluh hanya lihat konsultasi dari petani di desa/kecamatan tertentu
            // $konsultasi = Konsultasi::with(['user', 'user.desa'])
            //     ->whereHas('user.desa', function ($query) use ($user) {
            //         if ($user && $user->id_desa) {
            //             $desa = Desa::find($user->id_desa);
            //             if ($desa) {
            //                 $query->where('id_kecamatan', $desa->id_kecamatan);
            //             }
            //         }
            //     })->get();

            // penyuluh hanya lihat konsultasi dengan tanaman yang sama
            $konsultasi = Konsultasi::with(['user', 'tanaman'])
                ->whereHas('tanaman', function ($query) use ($user) {
                    if ($user && $user->id_tanaman) {
                        $query->where('id_tanaman', $user->id_tanaman);
                    }
                })->get();

        } else {
            // admin & kepala_dinas bisa lihat semua
            $konsultasi = Konsultasi::with('user')->get();
        }

        return view('livewire.konsultasi-table', [
            'konsultasi' => $konsultasi,
        ]);
    }
}

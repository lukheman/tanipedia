<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Enums\State;
use App\Livewire\Forms\UserForm;
use App\Models\Admin;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\KepalaDinas;
use App\Models\Penyuluh;
use App\Models\Tanaman;
use App\Models\User;
use App\Traits\Traits\WithModal;
use App\Traits\WithNotify;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen Pengguna')]
class PenggunaPage extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public UserForm $form;

    public $currentState = State::CREATE;

    public $idModal = 'modal-form-pengguna';

    public $kecamatanList;

    public $desaList;

    public $selectedDesa;

    public $selectedKecamatan;

    public $kecamatan;

    public $type;

    public $tanamanList;

    public $showTanamanField = false;

    public function mount()
    {
        $this->kecamatanList = Kecamatan::all();
        $this->desaList = collect(); // Initialize as empty

        $this->tanamanList = Tanaman::all();
    }

    public function updatedKecamatan($value)
    {
        $this->desaList = $value ? Desa::where('id_kecamatan', $value)->get() : collect();
    }

    public function updatedType($value)
    {
        if ($this->type === Role::AHLIPERTANIAN->value) {
            $this->showTanamanField = true;
        } else {
            $this->showTanamanField = false;
        }
    }

    public function detail($id, $role)
    {
        $role = Role::from($role);

        if ($role === Role::ADMIN) {
            $user = Admin::query()->find($id);
        } elseif ($role === Role::PETANI) {
            $user = User::with('desa')->find($id);
        } elseif ($role === Role::AHLIPERTANIAN) {
            $user = Penyuluh::with('desa')->find($id);
        } elseif ($role === Role::KEPALADINAS) {
            $user = KepalaDinas::query()->find($id);
        }

        $this->form->type = $role->value;
        $this->type = $role->value;
        $this->currentState = State::SHOW;
        $this->form->user = $user;
        $this->form->name = $user->name;
        $this->form->email = $user->email;
        $this->form->role = $user->role;
        $this->form->telepon = $user->telepon;
        $this->form->tanggal_lahir = $user->tanggal_lahir;
        $this->form->id_tanaman = $user->id_tanaman ?? null;
        $this->form->id_desa = $user->desa->id_desa ?? null;
        $this->kecamatan = $user->desa->id_kecamatan ?? null;
        $this->selectedDesa = $user->desa->nama ?? null;
        $this->selectedKecamatan = optional(
            Kecamatan::find(optional($user->desa)->id_kecamatan)
        )->nama;
        $this->updatedKecamatan($this->kecamatan); // Load desa list for the selected kecamatan
        $this->showTanamanField = true;
        $this->openModal($this->idModal);

    }

    public function edit($id, $role)
    {
        $this->detail($id, $role);
        $this->currentState = State::UPDATE;
    }

    public function save()
    {

        if ($this->currentState === State::CREATE) {

            $this->validate([
                'type' => 'required',
            ]);

            $this->form->type = $this->type;
            $this->form->store();
            $this->notifySuccess('Pengguna berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Pengguna berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);

    }

    public function delete(int $id, $type)
    {
        $type = Role::from($type);

        if ($type === Role::ADMIN) {
            $this->form->user = Admin::findOrFail($id);
        } elseif ($type === Role::PETANI) {
            $this->form->user = User::findOrFail($id);
        } elseif ($type === Role::AHLIPERTANIAN) {
            $this->form->user = Penyuluh::findOrFail($id);
        } elseif ($type === Role::KEPALADINAS) {
            $this->form->user = KepalaDinas::findOrFail($id);
        }

        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus pengguna ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        try {
            $this->form->delete();
            $this->notifySuccess('Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            $this->notifyError('Gagal menghapus pengguna: '.$e->getMessage());
        }
    }

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function render()
    {
        // Ambil data dari semua tabel
        $petani = User::with('desa')->get()->map(function ($item) {
            $item->id = $item->id_petani;

            return $item;
        });

        $admin = Admin::all()->map(function ($item) {
            $item->id = $item->id_admin;

            return $item;
        });

        $penyuluh = Penyuluh::with('desa')->get()->map(function ($item) {
            $item->id = $item->id_penyuluh;

            return $item;
        });

        $kepalaDinas = KepalaDinas::all()->map(function ($item) {
            $item->id = $item->id_kepala_dinas;

            return $item;
        });

        // Gabungkan jadi satu collection
        $allUsers = $petani
            ->concat($admin)
            ->concat($penyuluh)
            ->concat($kepalaDinas);

        // Sortir berdasarkan created_at
        $allUsers = $allUsers->sortByDesc('created_at');

        // Paginasi manual
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allUsers->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator(
            $currentItems,
            $allUsers->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.pengguna-page', [
            'users' => $paginated,
        ]);
    }
}

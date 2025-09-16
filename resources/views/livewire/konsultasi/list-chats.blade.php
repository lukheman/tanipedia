@php

use App\Enums\Role;

@endphp
<div class="card">

    <!-- modal tambah konsultasi baru -->
        <div class="modal fade" id="modal-form-konsultasi" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="myModalLabel1">
Buat Konsultasi Baru
                        </h5>
                        <button type="button" class="close rounded-pill" wire:click="$dispatch('closeModal', {id: 'modal-form-konsultasi'})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body">
                    <livewire:form-konsultasi-page />
                    </div>
                    <!-- <div class="modal-footer"> -->
                        <!-- <button type="button" wire:click="save" class="btn btn-primary">Perbarui</button> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>


    <div class="card-header">
@if ($activeRole === Role::PETANI)
        <button class="btn btn-primary w-100" wire:click="$dispatch('openModal', {id: 'modal-form-konsultasi'})">Buat konsultasi baru</button>


@endif
    </div>
    <div class="card-content pb-4">

        @forelse ($this->konsultasiList() as $konsultasi)
        <div wire:click="select({{ $konsultasi->id_konsultasi}})" class="recent-message d-flex px-4 py-3">

            @if ($activeRole === Role::PETANI)
            <div class="avatar avatar-lg">
                <img src="{{ $konsultasi->penyuluh->photo ? asset('storage/' . $konsultasi->penyuluh->photo) : asset('./assets/compiled/jpg/2.jpg') }}">
            </div>
            <div class="name ms-4">
                <p class="mb-1 fw-bold">{{ $konsultasi->penyuluh->name}}</p>
                <small class="text-muted mb-0 fw-b">{{ $konsultasi->penyuluh->desa->nama}} </small>
            </div>
             <!-- Tombol Batalkan -->
            <div>
                <button wire:click.stop="delete({{ $konsultasi->id_konsultasi }})"
                        class="btn btn-sm btn-danger">
                    Batalkan
                </button>
            </div>

            @endif

            @if ($activeRole === Role::AHLIPERTANIAN)
            <div class="avatar avatar-lg">
                <img src="{{ $konsultasi->user->photo ? asset('storage/' .  $konsultasi->user->photo) : asset('./assets/compiled/jpg/2.jpg') }}">
            </div>
            <div class="name ms-4">
                <h5 class="mb-1">{{ $konsultasi->user->name}}</h5>
                <h6 class="text-muted mb-0">Desa {{ $konsultasi->user->desa->nama}}</h6>
            </div>

            @endif
        </div>
         @empty
        <div class="text-center text-muted py-4">
            Belum ada konsultasi.
        </div>
        @endforelse

    </div>
</div>

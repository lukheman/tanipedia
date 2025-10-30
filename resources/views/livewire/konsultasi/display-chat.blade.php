@php

use App\Enums\Role;
use App\Enums\StatusKonsultasi;

@endphp
<div class="card" wire:poll>

    @isset($konsultasi)

<div class="card-header d-flex justify-content-between align-items-center">
    <div class="media d-flex align-items-center">
        <div class="avatar me-3">
            @isset($konsultasi)
                @if ($activeRole === Role::PETANI)
                    <img src="{{ $konsultasi->penyuluh->photo ? asset('storage/' . $konsultasi->penyuluh->photo) : asset('./assets/compiled/jpg/2.jpg') }}" alt="" srcset="">
                @endif

                @if ($activeRole === Role::AHLIPERTANIAN)
                    <img src="{{ $konsultasi->user->photo ? asset('storage/' . $konsultasi->user->photo) : asset('./assets/compiled/jpg/2.jpg') }}" alt="" srcset="">
                @endif
            @endisset
            <span class="avatar-status bg-success"></span>
        </div>
        <div class="name flex-grow-1">
            @isset($konsultasi)
                @if ($activeRole === Role::PETANI)
                    <h6 class="mb-0">{{ $konsultasi?->penyuluh->name ?? 'Tidak ada data' }}</h6>
                @endif
                @if ($activeRole === Role::AHLIPERTANIAN)
                    <h6 class="mb-0">{{ $konsultasi?->user->name ?? 'Tidak ada data' }}</h6>
                @endif
            @endisset
            <span class="text-xs">Online</span>
        </div>
    </div>

    {{-- Judul konsultasi di sebelah kanan --}}
    @isset($konsultasi)
        <div class="text-end">
            <h6 class="mb-0 text-primary fw-bold">
                {{ $konsultasi->judul ?? 'Tanpa Judul' }}
            </h6>
        </div>
    @endisset
</div>
    <div class="card-body pt-4 bg-grey">
        <div class="chat-content">

    <x-flash-message />

@if (isset($konsultasi))

@foreach ($konsultasi->pesan as $pesan)
    <div class="chat @if ($pesan->role_pengirim !== $activeRole) chat-left @endif">
        <div class="chat-body">
            <div class="chat-message">
                {{-- Isi teks pesan --}}
                @if ($pesan->isi)
                    <p class="mb-1">{{ $pesan->isi }}</p>
                @endif

                {{-- Tampilkan gambar jika ada --}}
                @if ($pesan->gambar)
                    <div class="mt-1">
                        <img
                            src="{{ asset('storage/' . $pesan->gambar) }}"
                            alt="Gambar pesan"
                            class="rounded border"
                            style="max-width: 150px; max-height: 150px; object-fit: cover;"
                        >
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach

@endif

        </div>
    </div>
<div class="card-footer">
    <div class="message-form d-flex flex-column align-items-center w-100">

        {{-- Preview gambar jika ada --}}
        @if ($form->gambar)
            <div class="w-100 text-start mb-2">
                <img
                    src="{{ $form->gambar->temporaryUrl() }}"
                    alt="Preview Gambar"
                    class="rounded border"
                    style="max-width: 80px; max-height: 80px; object-fit: cover;"
                >
                <button
                    type="button"
                    wire:click="$set('form.gambar', null)"
                    class="btn btn-sm btn-link text-danger p-0 ms-2 align-middle"
                >
                    Hapus
                </button>
            </div>
        @endif

        <div class="d-flex w-100 align-items-center">
            {{-- Input pesan teks --}}
            <input
                wire:model="form.isi"
                type="text"
                class="form-control me-2"
                placeholder="Tulis pesan..."
                style="flex: 1;"
                @if ($konsultasi->status === StatusKonsultasi::PENDING) disabled @endif
            >

            {{-- Tombol upload gambar --}}
            <label class="btn btn-outline-secondary mb-0 me-2">
                <i class="bi bi-image"></i>
                <input
                    type="file"
                    wire:model="form.gambar"
                    accept="image/*"
                    hidden
                    @if ($konsultasi->status === StatusKonsultasi::PENDING) disabled @endif
                >
            </label>

            {{-- Tombol kirim --}}
            <button
                type="button"
                wire:click="kirimPesan"
                class="btn btn-primary"
                @if ($konsultasi->status === StatusKonsultasi::PENDING) disabled @endif
            >
                Kirim
            </button>
        </div>

    </div>
</div>

    @else
    <div class="card-body">

        <p class="text-center">

            Pilih percakapan yang ingin ditampilkan
        </p>
    </div>
    @endisset

</div>

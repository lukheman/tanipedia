@php

use App\Enums\Role;
use App\Enums\StatusKonsultasi;

@endphp
<div class="card">

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
        <div class="chat  @if ($pesan->role_pengirim !== $activeRole) chat-left @endif">
            <div class="chat-body">
                <div class="chat-message">{{ $pesan->isi }}
    </div>
            </div>
        </div>

@endforeach

@endif

        </div>
    </div>
    <div class="card-footer">
        <div class="message-form d-flex flex-direction-column align-items-center">

<div class="btn-group d-flex flex-grow-1 ms-4">
                <input wire:model="pesan" type="text" class="form-control" placeholder="Type your message.." @if ($konsultasi->status === StatusKonsultasi::PENDING) disabled @endif>
<button type="button" wire:click="kirimPesan" class="btn btn-primary" @if ($konsultasi->status === StatusKonsultasi::PENDING) disabled @endif>Kirim</button>
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

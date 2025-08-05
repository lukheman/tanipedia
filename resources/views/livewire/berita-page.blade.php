@push('styles')
<style>
        #modal-show-berita img {
            max-width: 100%; /* Agar responsif */
            width: 300px; /* Atur lebar tetap, misalnya 300px */
            height: auto; /* Jaga rasio aspek */
        }
    </style>

@endpush
<div class="card">
    <div class="card-body">


    <a href="{{ route('berita.add')}}" class="btn btn-primary" wire:navigate>
    <i class="bi bi-pencil"></i>
    Tulis Berita</a>

<div class="modal fade" id="modal-show-berita" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="myModalLabel1">
                    <i class="bi bi-eye"></i> Lihat Berita
                </h5>
                    <button type="button" class="close rounded-pill" aria-label="Close" wire:click="$dispatch('closeModal', {id: 'modal-show-berita'})">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold" for="judul">Judul Berita</label>
                        <input type="text" id="judul" wire:model="judul" class="form-control-plaintext border rounded px-3 py-2" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="tanggal-publikasi">Tanggal Publikasi</label>
                        <input type="text" id="tanggal-publikasi" wire:model="tanggal_publikasi" class="form-control-plaintext border rounded px-3 py-2" readonly>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label fw-semibold" for="isi">Isi Berita</label>
                    <div class="border rounded p-3 bg-light overflow-auto" style="max-height: 400px;">
                        <div wire:model="isi" id="isi" class="text-dark" style="white-space: pre-line;">
                            {!! $isi !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> -->
                <!--     <i class="bi bi-x-circle"></i> Tutup -->
                <!-- </button> -->
            </div>
        </div>
    </div>
</div>

    @if ($currentState === \App\Enums\State::LISTDATA)
    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Judul Berita</th>
                    <th>Tanggal Publikasi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($berita as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->label_judul }}</td>
                    <td>{{ $item->tanggal_publikasi}}</td>
                    <td class="text-end">
                        <button wire:click="detail({{ $item }})"class="btn btn-sm btn-info">Lihat</button>
                        <a href="{{ route('berita.edit', ['id' => $item->id])}}" class="btn btn-sm btn-warning">Edit</a>
                        <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger">Hapus</button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :items="$berita" />
    </div>
    @elseif($currentState === \App\Enums\State::CREATE)
    <livewire:form-berita-page />
    @endif
    </div>
</div>

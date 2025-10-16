@push('styles')
<!-- Tambahkan style agar card bisa klik -->
<style>
    .option-card {
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        border-radius: 12px;
    }
    input[type="radio"]:checked + .option-card {
        border-color: #dc3545; /* warna merah Bootstrap */
        box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
    }
    .option-card:hover {
        border-color: #aaa;
    }
</style>

@endpush
<div class="card">

    <div class="card-header">


<!-- Modal Pilih Jenis Laporan Yang dicetak (petani/penyuluh) -->
<div class="modal fade text-left" id="modal-cetak-laporan-konsultasi" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel120">Download Laporan</h5>
                <button wire:click="$dispatch('closeModal', {id: 'modal-cetak-laporan-konsultasi'})" type="button" class="close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="row g-3">

                    <!-- Card Pilih Petani -->
                    <div class="col-6">
                        <label class="w-100">
                            <input type="radio" wire:model="tipe_laporan"  value="petani" class="d-none" checked>
                            <div class="card shadow-sm text-center p-3 option-card">
                                <i class="bi bi-person-fill fs-1 text-primary"></i>
                                <h6 class="mt-2">Petani</h6>
                            </div>
                        </label>
                    </div>

                    <!-- Card Pilih Penyuluh -->
                    <div class="col-6">
                        <label class="w-100">
                            <input type="radio" wire:model="tipe_laporan"  value="penyuluh" class="d-none">
                            <div class="card shadow-sm text-center p-3 option-card">
                                <i class="bi bi-people-fill fs-1 text-success"></i>
                                <h6 class="mt-2">Penyuluh</h6>
                            </div>
                        </label>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button wire:click="next" type="button" class="btn btn-danger ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">
                        <i class="bi bi-arrow-right"></i> Lanjut
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfigurasi -->
<div class="modal fade text-left" id="modal-konfigurasi-laporan" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel120">Download Laporan</h5>
                <button wire:click="$dispatch('closeModal', {id: 'modal-konfigurasi-laporan'})"  class="close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="row">

                    @if ($tipe_laporan === 'petani')
                    <!-- Card Pilih Petani -->
                    <div class="col-12">
                        <label class="w-100">
                            <div class="card shadow-sm text-center p-3 option-card">
                                <i class="bi bi-person-fill fs-1 text-primary"></i>
                                <h6 class="mt-2">Petani</h6>
                            </div>
                        </label>
                    </div>

                            <div class="col-12 mb-3">
                                <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                <select wire:model.live="id_kecamatan" class="form-control" id="kecamatan">
                                    <option value="">Semua</option>
                                    @foreach ($this->kecamatanList() as $item)
                                        <option value="{{ $item->id_kecamatan }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('id_kecamatan')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="tahun" class="form-label fw-semibold">Tahun</label>
                                <input wire:model="tahun" type="number" class="form-control" id="tahun" placeholder="Tahun" min="1900" max="2100">
                                @error('tahun')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                    @elseif($tipe_laporan === 'penyuluh')

                    <!-- Card Pilih Penyuluh -->
                    <div class="col-12">
                        <label class="w-100">
                            <div class="card shadow-sm text-center p-3 option-card">
                                <i class="bi bi-people-fill fs-1 text-success"></i>
                                <h6 class="mt-2">Penyuluh</h6>
                            </div>
                        </label>
                    </div>

                        <div class="col-12 mb-3">

                            <label for="tanaman" class="form-label fw-semibold">Cetak penyuluh untuk tanaman</label>
                            <select wire:model.live="id_tanaman" class="form-select" id="tanaman" name="role">
                                <option value="">Semua</option>
                                @foreach ($this->tanamanList() as $tanaman)
                                    <option value="{{ $tanaman->id_tanaman }}">{{ $tanaman->nama }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <small class="d-block mt-1 text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                            <div class="col-12 mb-3">
                                <label for="tahun" class="form-label fw-semibold">Tahun</label>
                                <input wire:model="tahun" type="number" class="form-control" id="tahun" placeholder="Tahun" min="1900" max="2100">
                                @error('tahun')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                    @endif


                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button wire:click="download" type="button" class="btn btn-danger ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">
                        <i class="bi bi-printer"></i> Download
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>


<button class="btn btn-danger" type="button" wire:click="openModalDownload">
    <i class="bi bi-printer"></i>
    Download Laporan
</button>

    </div>


    <div class="card-body">



    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->name }}</td>
                    <td>{{ $item->email}}</td>
                    <td>{{ $item->telepon}}</td>
                    <td>{{ $item->tanggal_lahir}}</td>
                    <td><span class="badge bg-{{ $item->role->getColor() }}">{{ $item->role }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :items="$users" />
    </div>

    </div>

</div>

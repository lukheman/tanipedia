<div class="card">
    <div class="card-body">

        <!-- Modal Detail Konsultasi -->
        <div class="modal fade" id="modal-detail-konsultasi" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-eye"></i> Detail Konsultasi
                        </h5>
                        <button type="button" class="close rounded-pill" wire:click="$dispatch('closeModal', {id: 'modal-detail-konsultasi'})">
                            ✕
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Informasi Petani -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nama Petani</label>
                                <input type="text" wire:model="nama_petani" class="form-control-plaintext border rounded px-3 py-2 bg-white" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tanggal Konsultasi</label>
                                <input type="text" wire:model="tanggal_konsultasi" class="form-control-plaintext border rounded px-3 py-2 bg-white" disabled>
                            </div>
                        </div>

                        <!-- Detail Konsultasi -->
                        <div class="mb-4">
                            <h6 class="fw-bold">Detail Konsultasi</h6>
                            <div class="border rounded p-3 bg-light">
                                <p><strong>Tanaman:</strong> {{ $nama_tanaman }}</p>
                                <hr>
                                <p><strong>Keluhan:</strong></p>
                                <div class="text-dark" style="white-space: pre-line;">{{ $isi }}</div>
                            </div>
                        </div>

                        <!-- Jawaban -->
                        <div class="mb-2">
                            <h6 class="fw-bold">Jawaban Penyuluh Pertanian</h6>
                            <div class="border rounded p-3 bg-light">
                                <p><strong>Ditanggapi oleh:</strong> {{ $nama_ahli_pertanian ?? 'Penyuluh Pertanian Tidak Ada' }}</p>
                                <hr>
                                <div class="text-dark" style="white-space: pre-line;">
                                    {{ $jawaban ?? 'Belum ada jawaban.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Jawab -->
        @auth('penyuluh')
        <div class="modal fade" id="modal-jawab" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white"><i class="bi bi-pencil-square"></i> Berikan solusi dan saran</h5>
                        <button type="button" class="close rounded-pill" wire:click="$dispatch('closeModal', {id: 'modal-jawab'})">✕</button>
                    </div>
                    <div class="modal-body">
                        <textarea wire:model="jawaban" class="form-control" rows="10" placeholder="Masukkan tanggapan atau saran untuk petani."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="kirimJawaban" type="button" class="btn btn-primary" data-bs-dismiss="modal">Kirim Jawaban</button>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        <!-- Modal Chat -->

        <!-- Tabel Konsultasi -->
        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                    <tr>
                        {{-- Hanya non-petani yang melihat kolom Nama Pengguna --}}
                        @auth('admin')
                            <th>Nama Pengguna</th>
                        @endauth
                        @auth('penyuluh')
                            <th>Nama Pengguna</th>
                        @endauth
                        @auth('kepala_dinas')
                            <th>Nama Pengguna</th>
                        @endauth

                        <th>Tanggal Konsultasi</th>
                        <th>Jenis Tanaman</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($konsultasi as $item)
                        <tr>
                            {{-- Nama pengguna hanya muncul kalau bukan petani --}}
                            @auth('admin')
                                <td class="text-bold-500">{{ $item->user->name }}</td>
                            @endauth
                            @auth('penyuluh')
                                <td class="text-bold-500">{{ $item->user->name }}</td>
                            @endauth
                            @auth('kepala_dinas')
                                <td class="text-bold-500">{{ $item->user->name }}</td>
                            @endauth

                            <td>{{ $item->tanggal_konsultasi }}</td>
                            <td>{{ $item->tanaman->nama }}</td>
                            <td><span class="badge bg-{{$item->status->getColor()}}">{{ $item->status->getLabel()}}</span></td>
                            <td class="text-end">
                                {{-- Admin & penyuluh bisa jawab / hapus --}}
                                @auth('admin')
                                    <button wire:click="detail({{ $item->id_konsultasi }})" class="btn btn-sm btn-info">Detail</button>
                                    <button wire:click="delete({{ $item->id_konsultasi }})" class="btn btn-sm btn-danger">Hapus</button>
                                @endauth

                                @auth('penyuluh')
                                    <button wire:click="detail({{ $item->id_konsultasi }})" class="btn btn-sm btn-info">Detail</button>
                                    <button wire:click="jawab({{ $item->id_konsultasi }})" class="btn btn-sm btn-primary">Jawab</button>
                                @endauth

                                {{-- Petani hanya bisa lihat jawaban --}}
                                @auth('petani')
                                    <button wire:click="openChat({{ $item->id_konsultasi }})" class="btn btn-sm btn-info">Lihat Percakapan</button>
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

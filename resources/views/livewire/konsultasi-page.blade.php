@php
    use App\Enums\Role;
    $role = Role::from(auth()->user()->role);
@endphp
<div class="card">
    <div class="card-body">


<div class="modal fade" id="default" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content shadow-lg rounded-3">
            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="myModalLabel1">
                    <i class="bi bi-eye"></i> Detail Konsultasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <!-- Informasi Petani -->
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold" for="judul">Nama Petani</label>
                        <input type="text" id="judul" wire:model="nama_petani" class="form-control-plaintext border rounded px-3 py-2 bg-white" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="tanggal-publikasi">Tanggal Konsultasi</label>
                        <input type="text" id="tanggal-publikasi" wire:model="tanggal_konsultasi" class="form-control-plaintext border rounded px-3 py-2 bg-white" readonly>
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
                    <h6 class="fw-bold">Jawaban Ahli Pertanian</h6>
                    <div class="border rounded p-3 bg-light">

                        <p><strong>Ditanggapi oleh:</strong> {{ $nama_ahli_pertanian ?? 'Ahli Pertanian Tidak Ada' }}</p>
                        <hr>
                        <div class="text-dark" style="white-space: pre-line;">
                            {{ $jawaban ?? 'Belum ada jawaban.' }}
                        </div>


                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

                                    <div class="modal fade" id="modal-jawab" tabindex="-1" >
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                    <div class="modal-content shadow-lg rounded-3">
                                    <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title text-white" id="myModalLabel1">
                                    <i class="bi bi-eye"></i> Berikan solusi dan saran
                                    </h5>
                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group">

                                    <!-- <label class="form-label fw-semibold" for="jawaban">Berikan Solusi</label> -->
                                    <textarea wire:model="jawaban" class="form-control" rows="10" placeholder="Masukkan tanggapan atau saran yang dapat membantu petani mengatasi keluhannya."></textarea>
                                    </div>
                                    </div>

                                    <div class="modal-footer">


                                    <button wire:click="kirimJawaban" type="button" class="btn btn-primary" data-bs-dismiss="modal">Kirim Jawaban</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>

                                    <div class="table-responsive">
                                    <table class="table table-lg">
                                    <thead>
                                    <tr>
                                    @if (auth()->user()->role !== \App\Enums\Role::PETANI->value)

                                    <th>Nama Pengguna</th>

                                    @endif
                                    <th>Tanggal Konsultasi</th>
                                    <th>Jenis Tanaman</th>
                                    <th class="text-end">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($konsultasi as $item)
                                    <tr>

                                    @if (auth()->user()->role !== \App\Enums\Role::PETANI->value)
                                    <td class="text-bold-500">{{ $item->user->name }}</td>
        @endif
                                    <td>{{ $item->tanggal_konsultasi }}</td>
                                    <td>{{ $item->nama_tanaman }}</td>
                                    <td class="text-end">
                                    @if ($role === Role::AHLIPERTANIAN || $role === Role::ADMIN )

                                    <button wire:click="detail({{ $item }})" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#default">Detail</button>
                                    <button wire:click="jawab({{ $item->id }})" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-jawab">Jawab</button>
                                    <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger" >Hapus</button>

                                    @elseif ($role === Role::PETANI)
                                    <button wire:click="detail({{ $item }})" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#default">Lihat Jawaban</button>
                                    @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">

<!-- Modal Detail Konsultasi -->
<div class="modal fade" id="modal-detail-konsultasi" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content shadow-lg rounded-3">
            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="myModalLabel1">
                    <i class="bi bi-eye"></i> Detail Konsultasi
                </h5>
                <button type="button" class="close rounded-pill" wire:click="$dispatch('closeModal', {id: 'modal-detail-konsultasi'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <!-- Nama Petani -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Petani</label>
                        <input type="text" class="form-control-plaintext border rounded px-3 py-2 bg-white"
                               value="{{ $nama_petani }}" readonly>
                    </div>

                    <!-- Nama Penyuluh -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Penyuluh Yang Menangani</label>
                        <input type="text" class="form-control-plaintext border rounded px-3 py-2 bg-white"
                               value="{{ $nama_penyuluh ?? 'Belum ditangani' }}" readonly>
                    </div>

                    <!-- Tanggal Konsultasi -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Konsultasi</label>
                        <input type="text" class="form-control-plaintext border rounded px-3 py-2 bg-white"
                               value="{{ $tanggal_konsultasi }}" readonly>
                    </div>

                    <!-- Nama Tanaman -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanaman</label>
                        <input type="text" class="form-control-plaintext border rounded px-3 py-2 bg-white"
                               value="{{ $nama_tanaman }}" readonly>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

        <div class="modal fade text-left show" id="modal-cetak-laporan-konsultasi" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title white" id="myModalLabel120">Download Laporan Konsultasi
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <form action="{{ route('print-laporan.konsultasi-kecamatan')}}" method="post">
                    @csrf

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="id" wire:model="kecamatan" id="kecamatan" class="form-control">
                                            <option value="">Pilih Kecamatan</option>
                                @foreach (\App\Models\Kecamatan::all() as $item)
                                <option value="{{ $item->id_kecamatan}}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Tahun" class="form-label">Tahun</label>
                            <input type="text" name="tahun" class="form-control" value="{{ date('Y')}}">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">
                                <i class="bi bi-printer"></i>
                                Download</span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

<button class="btn btn-danger" type="submit" wire:click="$dispatch('openModal', {id: 'modal-cetak-laporan-konsultasi'})">
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
                    <th>Tanggal Konsultasi</th>
                    <th>Jenis Tanaman</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($konsultasi as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->user->name }}</td>
                    <td>{{ $item->tanggal_konsultasi }}</td>
                    <td>{{ $item->tanaman->nama }}</td>
                    <td class="text-end">
                        <button wire:click="detail({{ $item->id_konsultasi }})" class="btn btn-sm btn-info">Detail</button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>

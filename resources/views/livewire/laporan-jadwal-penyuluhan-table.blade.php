<div class="card">
    <div class="card-header">

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
                    <form action="{{ route('print-laporan.kegiatan-penyuluhan')}}" method="post">
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

<!-- Modal Placeholder: Detail Jadwal Penyuluhan -->
<div class="modal fade" id="modal-show-jadwal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Detail Jadwal Penyuluhan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Tanggal</label>
                    <input type="text" class="form-control " wire:model="form.tanggal" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Deskripsi Kegiatan</label>
                    <textarea wire:model="form.kegiatan" class="form-control " rows="5" disabled></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input value="{{ ucfirst($form->status)}}" type="text" class="form-control text-{{ \App\Enums\StatusJadwal::from($form->status)->getColor() }} fw-semibold" disabled>
                </div>
            </div>

        </div>
    </div>
</div>

    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Desa</th>
                    <th>Penyuluh</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->jadwalPenyuluhan as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->tanggal }}</td>
                    <td>{{ $item->desa->nama }}</td>
                    <td>{{ $item->penyuluh->name }}</td>
                    <td class="text-end">
                        <button wire:click="detail({{ $item->id_jadwal_penyuluhan}})" class="btn btn-sm btn-info">Detail</button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    </div>


</div>

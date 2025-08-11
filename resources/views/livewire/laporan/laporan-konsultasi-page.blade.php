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
                    <form action="{{ route('print-laporan.konsultasi-kecamatan')}}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="id" wire:model="kecamatan" id="kecamatan" class="form-control">

                                            <option value="">Pilih Kecamatan</option>
                                @foreach (\App\Models\Kecamatan::all() as $item)
                                <option value="{{ $item->id}}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
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
                    <td>{{ $item->nama_tanaman }}</td>
                    <td class="text-end">
                    <form action="{{ route('print-laporan.konsultasi') }}" method="post">
                    @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                        <button type="submit" class="btn btn-sm btn-danger" >

    <i class="bi bi-printer"></i>
                                    Download</button>
                    </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>

<div class="card">
    <div class="card-body">


        <!-- Tabel Konsultasi -->
        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                    <tr>
                        <th>Tanggal Konsultasi</th>
                        <th>Jenis Tanaman</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->konsultasiList() as $item)
                        <tr>
                            <td>{{ $item->tanggal_konsultasi }}</td>
                            <td>{{ $item->tanaman->nama }}</td>
                            <td><span class="badge bg-{{ $item->status->getColor()}}">{{ $item->status->value }}</span></td>
                            <td class="text-end">
                                <button wire:click="accepted({{ $item->id_konsultasi }})" class="btn btn-sm btn-info">Terima</button>
                                <button wire:click="rejected({{ $item->id_konsultasi }})" class="btn btn-sm btn-danger">Tolak</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

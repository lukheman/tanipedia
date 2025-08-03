<div class="card">
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
                                    Cetak</button>
                    </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>

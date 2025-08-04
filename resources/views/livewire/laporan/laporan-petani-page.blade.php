<div class="card">
    <div class="card-header">

<a href="{{ route('print-laporan.petani')}}" class="btn btn-danger" type="submit">
    <i class="bi bi-printer"></i>
    Cetak Laporan
</a>

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
                    <th>Alamat</th>
                    <!-- <th class="text-end">Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <td class="text-bold-500">{{ $item->name }}</td>
                    <td>{{ $item->email}}</td>
                    <td>{{ $item->telepon}}</td>
                    <td>{{ $item->tanggal_lahir}}</td>
                    <td>{{ $item->alamat}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :items="$users" />
    </div>

    </div>
</div>

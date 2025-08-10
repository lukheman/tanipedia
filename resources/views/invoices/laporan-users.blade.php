

<x-laporan>

    <x-kop-laporan />

    <h5 class="report-title">Laporan Data Petani</h5>

    <p class="report-date">Laporan Data Petani - {{ date('d F Y')}}</p>


    <!-- Table -->
    <table id="petani">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <td class="center">{{ $loop->index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="center">{{ $item->telepon }}</td>
                    <td class="center">{{ $item->tanggal_lahir }}</td>
                    <td>Kecamatan {{ $item->desa->kecamatan->nama }} - Desa {{ $item->desa->nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <div class="total">
        <p>Total Petani: <strong>{{ $users->count() }}</strong></p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <div class="col"></div>
        <div class="col">
            <p>Dinas Tanaman Pangan <br> dan Hortikultura Kabupaten Kolaka</p>

            <p class="ttd">SUYANTO, SP., M.Si </p> <br>
            <p class="nip">NIP. 19650111 198709 1 001</p>
        </div>
    </div>
</x-laporan>

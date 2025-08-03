

<x-laporan>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>Dinas Pertanian</h2>
        <!-- <p>Jl. Raya Tani No. 123, Jakarta</p> -->
        <!-- <p>Telp: (021) 123-4567 | Email: info@dinaspertanian.jkt</p> -->
    </div>

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
            <p>Dinas Pertanian</p>
            <p class="ttd">{{ auth()->user()->name ?? 'Nama Penandatangan' }}</p>
        </div>
    </div>
</x-laporan>

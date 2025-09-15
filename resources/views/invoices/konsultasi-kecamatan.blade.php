<x-laporan>
    <!-- Kop Surat -->
    <x-kop-laporan />


    <h5 class="report-title">Laporan Konsultasi Petani</h5>

    <p class="report-date">Laporan Konsultasi - {{ date('d F Y') }}</p>

        <table id="petani">
            <thead>
                <tr>
                    <th>Tanggal Konsultasi</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Penyuluh</th>
                    <th>Jenis Tanaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($konsultasi as $item)
                <tr>
                    <td>{{ $item->tanggal_konsultasi }}</td>
                    <td class="text-bold-500">{{ $item->user->name }}</td>
                    <td class="text-bold-500">{{ $item->penyuluh->name }}</td>
                    <td>{{ $item->tanaman->nama }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <!-- Total -->
    <div class="total">
        <p>Total Konsultasi: <strong>{{ $konsultasi->count() }}</strong></p>
    </div>

    <!-- Tanda Tangan -->
    <x-signature />
</x-laporan>

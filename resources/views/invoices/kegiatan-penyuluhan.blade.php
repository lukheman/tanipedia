<x-laporan>
    <!-- Kop Surat -->
    <x-kop-laporan />

    <h5 class="report-title">Laporan Kegiatan Penyuluhan Kecamatan</h5>

    <p class="report-date">
        Tahun: <strong>{{ $tahun }}</strong><br>
        Tanggal Cetak: {{ date('d F Y') }}
    </p>

    @forelse ($penyuluhan as $item)
        <div class="penyuluhan-item" style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
            <p><strong>Nama Penyuluh:</strong> {{ $item->penyuluh->name ?? '-' }}</p>
            <p><strong>Lokasi Kunjungan:</strong> {{ $item->desa->nama ?? '-' }}</p>
            <p><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($item->tanggal_penyuluhan)->format('d F Y') }}</p>
            <p><strong>Jenis Kegiatan:</strong> {{ $item->jenis_kegiatan ?? '-' }}</p>
            <p><strong>Status Jadwal:</strong> {{ ucfirst($item->status->value ?? '-') }}</p>
        </div>
    @empty
        <p style="text-align: center; margin-top: 30px;">Tidak ada data kegiatan penyuluhan pada tahun {{ $tahun }}.</p>
    @endforelse

    <!-- Total -->
    <div class="total" style="margin-top: 30px;">
        <p>Total Kegiatan Penyuluhan: <strong>{{ $penyuluhan->count() }}</strong></p>
    </div>

    <!-- Tanda Tangan -->
    <x-signature />
</x-laporan>

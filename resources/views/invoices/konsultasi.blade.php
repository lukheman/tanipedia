<x-laporan>

    <x-kop-laporan />

    <p class="report-date">Laporan Konsultasi - {{ date('d F Y')}}</p>

    <h5 class="report-title">Detail Konsultasi</h5>

    <!-- Consultation Details -->
    <div class="detail-section">
        <h6>Nama Tanaman</h6>
        <p>{{ $konsultasi->nama_tanaman }}</p>

        <h6>Isi Konsultasi</h6>
        <p>{{ $konsultasi->isi }}</p>

        <h6>Jawaban Ahli Pertanian</h6>
        <p>
            @if ($konsultasi->hasil)
                {{ $konsultasi->hasil->isi }}
            @else
                Belum ada jawaban dari ahli pertanian
            @endif
        </p>

        <h6>Tanggal Konsultasi</h6>
        <p>{{ $konsultasi->created_at->format('d M Y') }}</p>
    </div>

    <!-- Tanda Tangan -->
    <x-signature />
</x-laporan>

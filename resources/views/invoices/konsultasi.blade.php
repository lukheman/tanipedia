<x-laporan>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>Dinas Pertanian</h2>
        <p>Jl. Raya Tani No. 123, Jakarta</p>
        <p>Telp: (021) 123-4567 | Email: info@dinaspertanian.jkt</p>
    </div>

    <p class="report-date">Laporan Konsultasi - 2 Agustus 2025</p>

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
    <div class="signature">
        <div class="col"></div>
        <div class="col">
            <p>Dinas Pertanian</p>
            <p class="ttd">{{ auth()->user()->name ?? 'Nama Penandatangan' }}</p>
        </div>
    </div>
</x-laporan>

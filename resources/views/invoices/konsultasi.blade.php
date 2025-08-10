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
    <div class="signature">
        <div class="col"></div>
        <div class="col">
            <p>Dinas Tanaman Pangan <br> dan Hortikultura Kabupaten Kolaka</p>
            <p class="ttd">SUYANTO, SP., M.Si </p> <br>
            <p class="nip">NIP. 19650111 198709 1 001</p>
        </div>
    </div>
</x-laporan>

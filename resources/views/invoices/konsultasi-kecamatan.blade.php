<x-laporan>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>Dinas Pertanian</h2>
        <!-- <p>Jl. Raya Tani No. 123, Jakarta</p> -->
        <!-- <p>Telp: (021) 123-4567 | Email: info@dinaspertanian.jkt</p> -->
    </div>

    <h5 class="report-title">Laporan Konsultasi Petani</h5>

    <p class="report-date">Laporan Konsultasi - {{ date('d F Y') }}</p>

    <!-- Consultation Entries -->
    @foreach ($konsultasi as $item)
        <div class="consultation-section">
            <h6>Konsultasi #{{ $loop->index + 1 }}</h6>
            <p><span class="label">Nama Petani:</span> {{ $item->user->name }}</p>
            <p><span class="label">Nama Tanaman:</span> {{ $item->nama_tanaman }}</p>
            <p><span class="label">Isi Konsultasi:</span> {{ $item->isi }}</p>
            <p><span class="label">Tanggal Konsultasi:</span> {{ $item->tanggal_konsultasi }}</p>
            @if ($item->id_solusi)
                <p class="solution"><span class="label">Hasil Konsultasi:</span> {{ $item->hasil->isi ?? 'Solusi tidak tersedia' }}</p>
            @else
                <p class="solution"><span class="label">Hasil Konsultasi:</span> Belum ada solusi</p>
            @endif
        </div>
    @endforeach

    <!-- Total -->
    <div class="total">
        <p>Total Konsultasi: <strong>{{ $konsultasi->count() }}</strong></p>
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

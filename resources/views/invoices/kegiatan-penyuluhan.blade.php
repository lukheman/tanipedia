<x-laporan>
    <!-- Kop Surat -->
    <x-kop-laporan />

    <style>
        .report-container {
            font-family: "Segoe UI", sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 20px;
        }

        .report-title {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #2b2b2b;
        }

        .report-date {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        .penyuluhan-item {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: 0.2s ease;
        }

        .penyuluhan-item:hover {
            background-color: #f5f9ff;
            border-color: #b3d4fc;
        }

        .penyuluhan-header {
            font-weight: 600;
            font-size: 15px;
            color: #1a237e;
            margin-bottom: 10px;
            border-bottom: 2px solid #1a237e;
            display: inline-block;
            padding-bottom: 2px;
        }

        .penyuluhan-details p {
            margin: 4px 0;
            font-size: 14px;
        }

        .penyuluhan-details strong {
            display: inline-block;
            width: 160px;
            color: #222;
        }

        .total {
            margin-top: 40px;
            font-weight: 600;
            text-align: right;
            font-size: 15px;
            border-top: 2px solid #ccc;
            padding-top: 10px;
        }

        .empty-message {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 40px;
        }

        /* Print-friendly style */
        @media print {
            .penyuluhan-item {
                page-break-inside: avoid;
            }
        }
    </style>

    <div class="report-container">
        <h5 class="report-title">Laporan Kegiatan Penyuluhan Kecamatan</h5>

        <p class="report-date">
            Tahun: <strong>{{ $tahun }}</strong><br>
            Tanggal Cetak: {{ date('d F Y') }}
        </p>

        @forelse ($penyuluhan as $index => $item)
            <div class="penyuluhan-item">
                <div class="penyuluhan-header">
                    Kegiatan #{{ $index + 1 }}
                </div>
                <div class="penyuluhan-details">
                    <p><strong>Nama Penyuluh:</strong> {{ $item->penyuluh->name ?? '-' }}</p>
                    <p><strong>Lokasi Kunjungan:</strong> {{ $item->desa->nama ?? '-' }}</p>
                    <p><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($item->tanggal_penyuluhan)->format('d F Y') }}</p>
                    <p><strong>Jenis Kegiatan:</strong> {{ $item->kegiatan ?? '-' }}</p>
                    <p><strong>Laporan:</strong> {{ $item->laporan ?? '-' }}</p>
                    <p><strong>Status Jadwal:</strong>
                        <span style="color: {{ $item->status->value === 'selesai' ? '#2e7d32' : '#f57c00' }}">
                            {{ ucfirst($item->status->value ?? '-') }}
                        </span>
                    </p>
                </div>
            </div>
        @empty
            <p class="empty-message">Tidak ada data kegiatan penyuluhan pada tahun {{ $tahun }}.</p>
        @endforelse

        <div class="total">
            Total Kegiatan Penyuluhan: <strong>{{ $penyuluhan->count() }}</strong>
        </div>

        <!-- Tanda Tangan -->
        <x-signature />
    </div>
</x-laporan>

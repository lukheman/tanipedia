<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laporan')</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">
    <style>
            body {
                font-family: 'Source Sans Pro', sans-serif;
                font-size: 12pt;
                margin: 0;
                padding: 0;
            }
        .container {
            width: 100%;
            margin: 0 auto;
            /* padding: 10px 20px; */
            background: white;
        }
        .kop-surat {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 3px solid #000;
            margin-bottom: 20px;
        }
        .kop-surat h6 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 2rem;
        }
        .kop-surat p {
            margin: 2px 0;
            color: #555;
            font-size: 1.1rem;
        }
        .report-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            margin: 20px 0;
            padding-bottom: 5px;
        }
        .report-date {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 20px;
        }
        .detail-section {
            margin: 20px 0;
        }
        .detail-section h6 {
            font-weight: 600;
            color: #435ebe;
            margin-bottom: 10px;
            font-size: 1.25rem;
        }
        .detail-section p {
            margin: 5px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #435ebe;
            border-radius: 4px;
            font-size: 1.1rem;
        }
        .consultation-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #435ebe;
            border-radius: 4px;
        }
        .consultation-section h6 {
            font-weight: 600;
            color: #435ebe;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .consultation-section p {
            margin: 5px 0;
            font-size: 1rem;
        }
        .consultation-section .label {
            font-weight: 600;
            color: #555;
        }
        .consultation-section .solution {
            background-color: #e6ecff;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            page-break-inside: avoid; /* Biar tidak terpotong */
        }
        .signature .col {
            flex: 1;
            text-align: center;
        }
        .signature p {
            margin: 2px 0;
            font-size: 12pt;
        }
        .signature .ttd {
            margin-top: 60px; /* ruang untuk tanda tangan */
            font-weight: 600;
        }

        .signature .nip {
            display: inline-block;
            border-top: 2px solid #000;
            padding-top: 2px;
            font-weight: 600;
        }
        table#petani {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }
        table#petani th, table#petani td {
            border: 1px solid #000;
            padding: 5px;
        }
        table#petani thead {
            background-color: #ddd !important;
            color: black !important;
        }
        table#petani th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
        }
        table#petani td {
            padding: 10px;
            border-bottom: 1px solid #000;
        }
        table#petani tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table#petani tbody tr:hover {
            background-color: #eef1ff;
        }
        table#petani td.center {
            text-align: center;
        }
        .total {
            margin-top: 20px;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: right;
        }
        @media print {
            body {
                background: white;
            }
            .container {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
            table#petani {
                font-size: 0.9rem;
            }
            table#petani th, table#petani td {
                padding: 8px;
            }
            .consultation-section {
                break-inside: avoid;
            }
        }
        @page {
            size: A4 portrait;
            margin: 20mm;
        }
    </style>
</head>
<body>
    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>

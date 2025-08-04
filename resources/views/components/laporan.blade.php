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
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .kop-surat {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 3px solid #435ebe;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            font-weight: 700;
            color: #435ebe;
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
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature .col {
            flex: 1;
            text-align: center;
        }
        .signature .col p {
            margin: 0;
            font-size: 1.1rem;
        }
        .signature .col .ttd {
            margin-top: 80px;
            border-top: 2px solid #333;
            display: inline-block;
            padding-top: 5px;
            font-weight: 600;
            font-size: 1.1rem;
        }
        table#petani {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
        }
        table#petani thead {
            background-color: #435ebe;
            color: white;
        }
        table#petani th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
        }
        table#petani td {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
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
    </style>
</head>
<body>
    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>

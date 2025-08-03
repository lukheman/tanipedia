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
        @media print {
            body {
                background: white;
            }
            .container {
                box-shadow: none;
                margin: 0;
                width: 100%;
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

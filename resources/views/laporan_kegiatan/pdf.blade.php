<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan</title>

    <style>
        body {
            font-family: sans-serif; /* DejaVu Sans sering bikin file PDF jadi berat, pakai sans-serif standar dulu */
            font-size: 12px;
            line-height: 1.5;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            width: 25%;
        }

        .uraian {
            margin: 20px 0;
            text-align: justify;
        }

        .foto-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .foto-table td {
            width: 50%;
            padding: 5px;
            border: none; /* Hilangkan border untuk grid foto */
            text-align: center;
        }

        .foto {
            width: 100%;
            max-width: 300px; /* Batasi ukuran agar tidak pecah */
            height: auto;
            border: 1px solid #333;
        }

        /* Supaya uraian tidak terpotong ke halaman sebelah jika terlalu panjang */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<h3>LAPORAN KEGIATAN</h3>

<table>
    <tr>
        <th>Tanggal</th>
        <td>{{ $laporan->tanggal_indo }}</td>
    </tr>
    <tr>
        <th>Kegiatan</th>
        <td>{{ $laporan->kegiatan->nama_kegiatan ?? '-' }}</td>
    </tr>
    <tr>
        <th>Waktu</th>
        <td>{{ $laporan->jam_indo }}</td>
    </tr>
    <tr>
        <th>Tempat</th>
        <td>{{ $laporan->tempat }}</td>
    </tr>
</table>

<div class="uraian">
    <strong>Uraian Kegiatan:</strong><br>
    {{ $laporan->uraian }}
</div>

<div style="margin-top: 20px;">
    <strong>Foto Kegiatan:</strong>
    <br><br>

    @if (is_array($laporan->foto) && count($laporan->foto))
        <div style="text-align: center;">
            @foreach ($laporan->foto as $foto)
                @php
                    $path = public_path('storage/' . $foto);
                    $base64 = '';

                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                @endphp

                @if($base64)
                    <div style="margin-bottom: 20px; page-break-inside: avoid;">
                        <img src="{{ $base64 }}" style="width: 100%; max-width: 600px; border: 1px solid #333;">
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <p>-</p>
    @endif
</div>

</body>
</html>
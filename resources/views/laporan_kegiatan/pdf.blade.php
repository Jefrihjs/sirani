<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #eee;
            width: 30%;
        }

        .uraian {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .foto-table {
            width: 100%;
            border-collapse: collapse;
        }

        .foto-table td {
            width: 50%;
            padding: 5px;
            border: none;
        }

        .foto {
            width: 100%;
            border: 1px solid #333;
        }
    </style>
</head>
<body>

@php
    use Carbon\Carbon;
@endphp

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
    <strong>Uraian:</strong>
    <p>{{ $laporan->uraian }}</p>
</div>

<strong>Foto Kegiatan:</strong>
<br><br>

@if (is_array($laporan->foto) && count($laporan->foto))
    <table class="foto-table">
        <tr>
        @foreach ($laporan->foto as $foto)
            @php
                $fullPath = storage_path('app/public/' . $foto);

                if (file_exists($fullPath)) {
                    $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
                    $data = file_get_contents($fullPath);
                    $base64 = 'data:image/' . $ext . ';base64,' . base64_encode($data);
                } else {
                    $base64 = null;
                }
            @endphp

            @if ($base64)
                <td>
                    <img src="{{ $base64 }}" class="foto">
                </td>
            @endif

            @if ($loop->iteration % 2 == 0)
                </tr><tr>
            @endif
        @endforeach
        </tr>
    </table>
@else
    <p>-</p>
@endif

</body>
</html>

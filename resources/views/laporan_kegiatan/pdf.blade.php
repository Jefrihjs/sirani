<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan</title>

    <style>
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 12px;
        color: #333;
        margin: 0.5cm;
    }
    .header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
    
    table.info {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table.info td {
        padding: 5px 0;
        border: none;
    }
    .label { width: 120px; font-weight: bold; }
    .separator { width: 10px; }

    .uraian-box {
        border-top: 1px solid #ccc;
        padding-top: 15px;
        text-align: justify;
    }
    .uraian-title {
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: block;
    }
    
    /* Grid Foto 2 Kolom */
    .foto-grid {
        width: 100%;
        margin-top: 20px;
    }
    .foto-item {
        width: 48%; 
        display: inline-block;
        vertical-align: top;
        margin-bottom: 20px;
        text-align: center;
    }
    .foto-container {
        width: 100%;
        height: 250px; 
        background-color: #f8f8f8; 
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        display: block;
    }
    .foto-img {
        width: 100%;
        height: 100%;
        object-fit: contain; 
        padding: 5px; 
    }
</style>

<body>
    <div class="header">
        <h2>Laporan Aktivitas Harian</h2>
        <div style="font-size: 11px; margin-top: 5px;">DiskominfoSP - Kab. Belitung Timur</div>
    </div>

    <table class="info">
        <tr>
            <td class="label">Nama Pegawai</td>
            <td class="separator">:</td>
            <td>{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <td class="label">Hari / Tanggal</td>
            <td class="separator">:</td>
            <td>{{ $laporan->tanggal_indo }}</td>
        </tr>
        <tr>
            <td class="label">Waktu Pelaksanaan</td>
            <td class="separator">:</td>
            <td>{{ $laporan->jam_indo }} WIB</td>
        </tr>
        <tr>
            <td class="label">Lokasi</td>
            <td class="separator">:</td>
            <td>{{ $laporan->tempat }}</td>
        </tr>
    </table>

    <div class="uraian-box">
        <span class="uraian-title">Uraian Kegiatan:</span>
        <div style="white-space: pre-line; line-height: 1.6;">
            {{ $laporan->uraian }}
        </div>
    </div>

    <div style="margin-top: 30px;">
        <span class="uraian-title">Dokumentasi Visual:</span>
        <div class="foto-grid">
            @foreach ($laporan->foto as $index => $foto)
                @php
                    $path = public_path('storage/' . $foto);
                    $base64 = '';
                    if (file_exists($path)) {
                        $data = file_get_contents($path);
                        $base64 = 'data:image/jpg;base64,' . base64_encode($data);
                    }
                @endphp
                @if($base64)
                    <div class="foto-item">
                        <div class="foto-container">
                            <img src="{{ $base64 }}" class="foto-img">
                        </div>
                        <div style="font-size: 9px; color: #666; margin-top: 5px; font-weight: bold; uppercase">
                            DOKUMENTASI {{ $index + 1 }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>
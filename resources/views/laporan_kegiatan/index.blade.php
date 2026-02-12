@extends('layouts.dashboard')
@section('title', 'Laporan Kegiatan')
@section('subtitle', 'Daftar aktivitas kerja')

@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M19.5 14.25V6a2.25 2.25 0 00-2.25-2.25H8.25A2.25 2.25 0 006 6v12a2.25 2.25 0 002.25 2.25h5.25" />
</svg>
@endsection
@section('content')

<div class="page-wrapper">

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <h1>
                Laporan Bulan
                {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}
                {{ $tahun }}
            </h1>
            <p class="page-subtitle">Daftar aktivitas kerja ASN</p>
        </div>

        <div class="page-actions">
            <form method="GET">
                <select name="bulan" onchange="this.form.submit()">
                    @foreach ([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ] as $num => $nama)
                        <option value="{{ $num }}"
                            {{ $bulan == $num ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>

                <input type="hidden" name="tahun" value="{{ $tahun }}">
            </form>

            <a href="{{ route('laporan_kegiatan.create') }}" class="link-cta">
                <span class="plus-icon">＋</span>
                Input Laporan
            </a>
        </div>

    </div>


    {{-- CARD --}}
    <div class="card">

        <table class="table-modern">

            <thead>
                <tr>
                    <th style="width:130px;">Tanggal</th>
                    <th>Kegiatan</th>
                    <th style="width:160px;">Waktu</th>
                    <th>Tempat</th>
                    <th style="width:140px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $row)
                <tr>

                    <td>{{ $row->tanggal }}</td>

                    <td>
                        {{ $row->kegiatan->nama_kegiatan }}
                    </td>

                    <td>
                        {{ $row->jam_mulai }} – {{ $row->jam_selesai }}
                    </td>

                    <td>
                        {{ $row->tempat }}
                    </td>

                    <td>
                        <div class="action-group">
                        <a href="{{ route('laporan_kegiatan.pdf', $row->id) }}"
                        target="_blank"
                        class="action-btn view"
                        title="Preview">
                            👁
                        </a>

                        <a href="{{ route('laporan_kegiatan.edit', $row->id) }}"
                        class="action-btn edit"
                        title="Edit">
                            ✏
                        </a>

                        <form action="{{ route('laporan_kegiatan.destroy', $row->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin hapus laporan ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="action-btn delete"
                                    title="Hapus">
                                🗑
                            </button>
                        </form>
                        </div>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        Belum ada laporan bulan ini
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection


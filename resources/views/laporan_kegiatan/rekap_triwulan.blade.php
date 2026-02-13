@extends('layouts.dashboard')
@section('title', 'Laporan Triwulan')
@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M3 3v18h18M9 17V9m4 8v-5m4 5V7" />
</svg>
@endsection
@section('content')

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1>Rekap Triwulan {{ $triwulan }} Tahun {{ $tahun }}</h1>
            <p class="page-subtitle">Ringkasan laporan kegiatan ASN</p>
        </div>
    </div>


    {{-- FILTER CARD --}}
    <div class="card mb-6">

        <form method="GET"
              action="{{ route('rekap.triwulan') }}"
              class="filter-bar">

            <div class="filter-group">

                {{-- TRI WULAN --}}
                <select name="triwulan" class="form-input small">
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ $triwulan == $i ? 'selected' : '' }}>
                            Triwulan {{ $i }}
                        </option>
                    @endfor
                </select>

                {{-- TAHUN --}}
                <input type="number"
                       name="tahun"
                       value="{{ $tahun }}"
                       class="form-input small"
                       style="width:120px;">

                {{-- KEGIATAN --}}
                <select name="kegiatan_id" class="form-input small">
                    <option value="">Semua Kegiatan</option>
                    @foreach ($daftarKegiatan as $kegiatan)
                        <option value="{{ $kegiatan->id }}"
                            {{ $kegiatanId == $kegiatan->id ? 'selected' : '' }}>
                            {{ $kegiatan->nama_kegiatan }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary small">
                    Tampilkan
                </button>

            </div>

            {{-- EXPORT --}}
            <a href="{{ route('rekap.triwulan.export', request()->query()) }}"
               class="btn-success">
                ⬇ Export Excel
            </a>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="card">

        <table class="table-modern">

            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th style="width:180px;">Tanggal</th>
                    <th>Nama Kegiatan</th>
                    <th>Uraian Kegiatan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                        </td>

                        <td>
                            {{ $row->kegiatan->nama_kegiatan ?? '-' }}
                        </td>

                        <td>
                            {{ $row->uraian }}
                        </td>

                        <td>
                            {{ $row->tempat ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            Tidak ada data rekap triwulan.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection


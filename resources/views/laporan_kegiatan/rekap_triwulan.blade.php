@extends('layouts.dashboard')

@section('content')
<h2 class="font-semibold text-xl">Rekap Triwulan {{ $triwulan }} Tahun {{ $tahun }}</h2>

    <div class="p-6">

        {{-- FILTER --}}
        <form method="GET" action="{{ route('laporan_kegiatan.rekap_triwulan') }}"
            style="display:flex; gap:10px; align-items:center; margin-bottom:20px;">

            {{-- TRI WULAN --}}
            <select name="triwulan">
                @for ($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $triwulan == $i ? 'selected' : '' }}>
                        Triwulan {{ $i }}
                    </option>
                @endfor
            </select>

            {{-- TAHUN --}}
            <input type="number" name="tahun" value="{{ $tahun }}" style="width:100px">

            {{-- 🔥 DROPDOWN KEGIATAN --}}
            <select name="kegiatan_id">
                <option value="">Semua Kegiatan</option>
                @foreach ($daftarKegiatan as $kegiatan)
                    <option value="{{ $kegiatan->id }}"
                        {{ $kegiatanId == $kegiatan->id ? 'selected' : '' }}>
                        {{ $kegiatan->nama_kegiatan }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Tampilkan</button>

            {{-- 🔥 TOMBOL EXPORT EXCEL --}}
            <a href="{{ route('rekap_triwulan.export', request()->query()) }}"
            style="
                    margin-left:auto;
                    background:#16a34a;
                    color:white;
                    padding:8px 14px;
                    border-radius:6px;
                    text-decoration:none;
                    font-weight:bold;
            ">
            ⬇️ Export Excel
            </a>
        </form>

        {{-- TABEL --}}
        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 w-12">No</th>
                    <th class="border p-2 w-40">Tanggal</th>
                    <th class="border p-2">Judul Kegiatan</th>
                    <th class="border p-2">Uraian Kegiatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $row)
                    <tr>
                        <td class="border p-2 text-center">
                            {{ $i + 1 }}
                        </td>
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="border p-2">
                            {{ $row->kegiatan->nama_kegiatan }}
                        </td>
                        <td class="border p-2">
                            {{ $row->uraian }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="border p-4 text-center text-gray-500">
                            Tidak ada data rekap triwulan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection

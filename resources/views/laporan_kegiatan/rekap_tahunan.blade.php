@extends('layouts.dashboard')

@section('content')
<h2 class="font-semibold text-xl">Rekap Tahunan {{ $tahun }}</h2>   

    <div class="p-6">

        <form method="GET"
            action="{{ route('laporan_kegiatan.rekap_tahunan') }}"
            style="display:flex; gap:10px; align-items:center; margin-bottom:20px;">

            {{-- TAHUN --}}
            <input type="number"
                name="tahun"
                value="{{ $tahun }}"
                style="width:100px">

            {{-- DROPDOWN KEGIATAN --}}
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

            {{-- 🔥 EXPORT --}}
            <a href="{{ route('rekap_tahunan.export', request()->query()) }}"
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

        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 w-12">No</th>
                    <th class="border p-2 w-36">Tanggal</th>
                    <th class="border p-2">Judul Kegiatan</th>
                    <th class="border p-2">Uraian Kegiatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $row)
                    <tr>
                        <td class="border p-2 text-center">{{ $i + 1 }}</td>
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="border p-2">{{ $row->kegiatan->nama_kegiatan }}</td>
                        <td class="border p-2">{{ $row->uraian }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border p-4 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection

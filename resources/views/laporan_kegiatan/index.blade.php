@extends('layouts.dashboard')

@section('content')
        <h2 class="font-semibold text-xl text-gray-800">
            Laporan Kegiatan
        </h2>
    <div class="p-6">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="flex items-center gap-3 mb-4">
            <select name="bulan"
                    class="border rounded px-3 py-2"
                    onchange="this.form.submit()">

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

            <a href="{{ route('laporan_kegiatan.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded">
                + Input Laporan
            </a>
        </form>

        <h2 class="text-lg font-semibold mb-2">
            Laporan Bulan
            {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}
            {{ $tahun }}
        </h2>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Kegiatan</th>
                    <th class="border p-2">Waktu</th>
                    <th class="border p-2">Tempat</th>
                    <th class="border p-2 w-32">Aksi</th> {{-- ⬅️ --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                <tr>
                    <td class="border p-2">{{ $row->tanggal }}</td>
                    <td class="border p-2">{{ $row->kegiatan->nama_kegiatan }}</td>
                    <td class="border p-2">
                        {{ $row->jam_mulai }} – {{ $row->jam_selesai }}
                    </td>
                    <td class="border p-2">{{ $row->tempat }}</td>

                    {{-- AKSI (HARUS DI DALAM TR) --}}
                  <td class="border p-2 text-center">
                    <div class="flex justify-center gap-3">

                        {{-- PREVIEW PDF --}}
                        <a href="{{ route('laporan_kegiatan.pdf', $row->id) }}"
                        target="_blank"
                        class="text-gray-600 hover:text-gray-900"
                        title="Preview PDF">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>

                        {{-- CETAK PDF --}}
                        <a href="{{ route('laporan_kegiatan.pdf', $row->id) }}"
                        target="_blank"
                        class="text-green-600 hover:text-green-800"
                        title="Cetak PDF">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5
                                        a2 2 0 012-2h16a2 2 0 012 2v5
                                        a2 2 0 01-2 2h-2M6 14h12v8H6v-8z" />
                            </svg>
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('laporan_kegiatan.edit', $row->id) }}"
                        class="text-blue-600 hover:text-blue-800"
                        title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11
                                        a2 2 0 002 2h11a2 2 0 002-2v-5
                                        M18.5 2.5a2.121 2.121 0 113 3
                                        L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ route('laporan_kegiatan.destroy', $row->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin hapus laporan ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-600 hover:text-red-800"
                                    title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142
                                            A2 2 0 0116.138 21H7.862
                                            a2 2 0 01-1.995-1.858L5 7
                                            m5 4v6m4-6v6
                                            M9 7h6m2 0H7
                                            m2-4h6a1 1 0 011 1v1
                                            H8V4a1 1 0 011-1z" />
                            </svg>
                            </button>
                        </form>

                    </div>
                </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border p-4 text-center text-gray-500">
                        Belum ada laporan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

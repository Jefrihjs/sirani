@extends('layouts.dashboard')

@section('content')
        <h2 class="font-semibold text-xl text-gray-800">
            Master Kegiatan
        </h2>

    <div class="py-6 px-6">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('master-kegiatan.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
            + Tambah Kegiatan
        </a>

        <div class="bg-white shadow rounded">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 w-12 text-center">No</th>
                        <th class="border p-2 text-left">Nama Kegiatan</th>
                        <th class="border p-2 w-24 text-center">Status</th>
                        <th class="border p-2 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $i => $row)
                        <tr>
                            <td class="border p-2 text-center">
                                {{ $i + 1 }}
                            </td>

                            <td class="border p-2">
                                {{ $row->nama_kegiatan }}
                            </td>

                            <td class="border p-2 text-center">
                                @if($row->aktif)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="border p-2 text-center">
                                <a href="{{ route('master-kegiatan.edit', $row->id) }}"
                                class="text-blue-600 hover:underline">
                                    Edit
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border p-4 text-center text-gray-500">
                                Belum ada data master kegiatan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

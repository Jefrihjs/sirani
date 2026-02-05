@extends('layouts.dashboard')

@section('content')
<h2 class="font-semibold text-xl text-gray-800">
            Edit Master Kegiatan
        </h2>

    <div class="py-6 px-6 max-w-xl">
        <form method="POST"
              action="{{ route('master-kegiatan.update', $row->id) }}"
              class="bg-white p-6 rounded shadow">

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">
                    Nama Kegiatan
                </label>
                <input type="text"
                       name="nama_kegiatan"
                       value="{{ old('nama_kegiatan', $row->nama_kegiatan) }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">
                    Status
                </label>
                <select name="aktif"
                        class="w-full border rounded px-3 py-2">
                    <option value="1" {{ $row->aktif ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="0" {{ !$row->aktif ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Simpan
                </button>

                <a href="{{ route('master-kegiatan.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

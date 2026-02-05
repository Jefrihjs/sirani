@extends('layouts.dashboard')

@section('content')
<h2 class="font-semibold text-xl">
            Tambah Kegiatan
        </h2>

    <div class="p-6">
        <form method="POST" action="{{ route('master-kegiatan.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Simpan
            </button>

            <a href="{{ route('master-kegiatan.index') }}"
               class="ml-2 text-gray-600">
               Kembali
            </a>
        </form>
    </div>
@endsection

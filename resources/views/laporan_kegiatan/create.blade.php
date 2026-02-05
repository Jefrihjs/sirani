@extends('layouts.dashboard')

@section('content')
        <h2 class="font-semibold text-xl text-gray-800">
            Input Laporan Kegiatan
        </h2>

<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-6">
        Input Laporan Kegiatan
    </h2>

    <form action="{{ route('laporan_kegiatan.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf

        <div>
            <label class="block text-sm font-medium">Kegiatan</label>
            <select name="master_kegiatan_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Kegiatan --</option>
                @foreach($kegiatan as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kegiatan }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border rounded p-2" required>
        </div>

        <div class="flex gap-4">
            <div class="w-1/2">
                <label class="block text-sm font-medium">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="w-full border rounded p-2" required>
            </div>
            <div class="w-1/2">
                <label class="block text-sm font-medium">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="w-full border rounded p-2" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Tempat</label>
            <input type="text" name="tempat" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Uraian</label>
            <textarea name="uraian" rows="4" class="w-full border rounded p-2" required></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium">Foto Kegiatan (min 2)</label>
            <input type="file" name="foto[]" multiple required>
        </div>

        <div style="margin-top:20px">
            <div class="pt-4 flex gap-3">
                <button type="submit"
                style="
                    background:#2563eb;
                    color:white;
                    padding:10px 18px;
                    border:none;
                    border-radius:6px;
                    font-weight:bold;
                    cursor:pointer;
                ">
                💾 Simpan Laporan
            </button>

                <a href="{{ route('laporan_kegiatan.index') }}"
                style="
                        margin-left:10px;
                        background:#e5e7eb;
                        color:#111827;
                        padding:10px 18px;
                        border-radius:6px;
                        text-decoration:none;
                        font-weight:bold;
                ">
                ↩️ Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

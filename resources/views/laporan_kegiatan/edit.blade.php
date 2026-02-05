@extends('layouts.dashboard')

@section('content')
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Laporan Kegiatan
        </h2>
    <div class="p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('laporan_kegiatan.update', $laporan->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- KEGIATAN --}}
            <div class="mb-4">
                <label class="font-semibold">Nama Kegiatan</label>
                <select name="master_kegiatan_id" class="w-full border p-2 rounded" required>
                    @foreach ($kegiatan as $k)
                        <option value="{{ $k->id }}"
                            {{ old('master_kegiatan_id', $laporan->master_kegiatan_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kegiatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TANGGAL --}}
            <div class="mb-4">
                <label class="font-semibold">Tanggal</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal', $laporan->tanggal) }}"
                       class="w-full border p-2 rounded" required>
            </div>

            {{-- JAM --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Jam Mulai</label>
                    <input type="time" name="jam_mulai"
                           value="{{ old('jam_mulai', $laporan->jam_mulai) }}"
                           class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="font-semibold">Jam Selesai</label>
                    <input type="time" name="jam_selesai"
                           value="{{ old('jam_selesai', $laporan->jam_selesai) }}"
                           class="w-full border p-2 rounded" required>
                </div>
            </div>

            {{-- TEMPAT --}}
            <div class="mb-4">
                <label class="font-semibold">Tempat</label>
                <input type="text" name="tempat"
                       value="{{ old('tempat', $laporan->tempat) }}"
                       class="w-full border p-2 rounded" required>
            </div>

            {{-- URAIAN --}}
            <div class="mb-6">
                <label class="font-semibold">Uraian</label>
                <textarea name="uraian" rows="4"
                          class="w-full border p-2 rounded"
                          required>{{ old('uraian', $laporan->uraian) }}</textarea>
            </div>

            {{-- FOTO --}}
            <div class="mb-6">
                <label class="font-semibold block mb-2">Foto Kegiatan</label>

                <div class="grid grid-cols-2 gap-4">
                    @foreach (($laporan->foto ?? []) as $index => $foto)
                        <div class="relative border rounded overflow-hidden h-48 bg-black">

                            <img src="{{ asset('storage/'.$foto) }}"
                                class="w-full h-full object-cover pointer-events-none">

                            {{-- FOTO 1 & 2 --}}
                            @if ($index < 2)
                                <button type="button"
                                    onclick="gantiFoto({{ $laporan->id }}, {{ $index }})"
                                    class="absolute bottom-2 right-2 z-30
                                        bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                    Ubah Foto
                                </button>
                            @endif

                            {{-- FOTO 3+ --}}
                            @if ($index >= 2)
                                <button type="button"
                                    onclick="hapusFoto({{ $laporan->id }}, {{ $index }})"
                                    class="absolute top-2 right-2 z-30
                                        bg-red-600 text-white w-8 h-8
                                        rounded-full text-lg leading-8 text-center">
                                    ×
                                </button>
                            @endif
                        </div>
                    @endforeach

                    {{-- TAMBAH FOTO --}}
                    <div onclick="tambahFoto({{ $laporan->id }})"
                        class="h-48 border-2 border-dashed rounded
                                flex items-center justify-center
                                cursor-pointer bg-gray-50">
                        <span class="text-4xl text-gray-400">+</span>
                    </div>
                </div>

                <small class="text-gray-500 block mt-2">
                    * Minimal 2 foto wajib. Foto ke-3 dst bisa dihapus.
                </small>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('laporan_kegiatan.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </div>

        </form>


    {{-- INPUT TERSEMBUNYI --}}
    <input type="file" id="fileGanti" hidden accept="image/*">
    <input type="file" id="fileTambah" hidden accept="image/*">

    <script>
        let laporanId = null;
        let fotoIndex = null;

        function gantiFoto(id, index) {
            laporanId = id;
            fotoIndex = index;
            document.getElementById('fileGanti').click();
        }

        document.getElementById('fileGanti').addEventListener('change', function () {
            if (!this.files.length) return;
            let fd = new FormData();
            fd.append('foto', this.files[0]);

            fetch(`/laporan_kegiatan/${laporanId}/foto/${fotoIndex}/replace`, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: fd
            }).then(r => r.ok ? location.reload() : alert('Gagal'));
        });

        function tambahFoto(id) {
            laporanId = id;
            document.getElementById('fileTambah').click();
        }

        document.getElementById('fileTambah').addEventListener('change', function () {
            if (!this.files.length) return;
            let fd = new FormData();
            fd.append('foto', this.files[0]);

            fetch(`/laporan_kegiatan/${laporanId}/foto/tambah`, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: fd
            }).then(r => r.ok ? location.reload() : alert('Gagal'));
        });

        function hapusFoto(id, index) {
            if (!confirm('Hapus foto ini?')) return;

            fetch(`/laporan_kegiatan/${id}/foto/${index}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(r => r.ok ? location.reload() : alert('Gagal'));
        }
    </script>
@endsection

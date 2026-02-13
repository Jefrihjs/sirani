@extends('layouts.dashboard')

@section('title', 'Edit Laporan')

@section('content')

<div class="form-wrapper">

    <div class="form-header">
        <div>
            <h1>Edit Laporan Kegiatan</h1>
            <p class="form-subtitle">Perbarui laporan kegiatan Anda</p>
        </div>

        <a href="{{ route('laporan_kegiatan.index') }}" class="link-back">
            ← Kembali
        </a>
    </div>

    <div class="form-card">

        @if ($errors->any())
            <div class="alert-danger mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('laporan_kegiatan.update', $laporan->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid-2">

                <div>
                    <label class="form-label">Nama Kegiatan</label>
                    <select name="master_kegiatan_id" class="form-input" required>
                        @foreach ($kegiatan as $k)
                            <option value="{{ $k->id }}"
                                {{ old('master_kegiatan_id', $laporan->master_kegiatan_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', $laporan->tanggal) }}"
                           class="form-input"
                           required>
                </div>

                <div>
                    <label class="form-label">Jam Mulai</label>
                    <input type="time"
                           name="jam_mulai"
                           value="{{ old('jam_mulai', $laporan->jam_mulai) }}"
                           class="form-input"
                           required>
                </div>

                <div>
                    <label class="form-label">Jam Selesai</label>
                    <input type="time"
                           name="jam_selesai"
                           value="{{ old('jam_selesai', $laporan->jam_selesai) }}"
                           class="form-input"
                           required>
                </div>

                <div>
                    <label class="form-label">Tempat</label>
                    <input type="text"
                           name="tempat"
                           value="{{ old('tempat', $laporan->tempat) }}"
                           class="form-input"
                           required>
                </div>

            </div>

            <div class="mt-6">
                <label class="form-label">Uraian</label>
                <textarea name="uraian"
                          rows="4"
                          class="form-input"
                          required>{{ old('uraian', $laporan->uraian) }}</textarea>
            </div>

            <div class="mt-8">
                <label class="form-label block mb-4">Foto Kegiatan</label>

                <div class="photo-grid">
                    @foreach (($laporan->foto ?? []) as $index => $foto)
                        <div class="photo-item">

                            <img src="{{ asset('storage/'.$foto) }}">

                            @if ($index < 2)
                                <button type="button"
                                        onclick="gantiFoto({{ $laporan->id }}, {{ $index }})"
                                        class="btn-photo-edit">
                                    Ubah
                                </button>
                            @endif

                            @if ($index >= 2)
                                <button type="button"
                                        onclick="hapusFoto({{ $laporan->id }}, {{ $index }})"
                                        class="btn-photo-delete">
                                    ×
                                </button>
                            @endif

                        </div>
                    @endforeach

                    <div onclick="tambahFoto({{ $laporan->id }})"
                         class="photo-add">
                        +
                    </div>
                </div>

                <small class="form-hint">
                    * Minimal 2 foto wajib. Foto ke-3 dst bisa dihapus.
                </small>
            </div>

            <div class="form-actions mt-8">
                <a href="{{ route('laporan_kegiatan.index') }}"
                   class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Update
                </button>
            </div>

        </form>

    </div>

</div>

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

function tambahFoto(id) {
    laporanId = id;
    document.getElementById('fileTambah').click();
}

function hapusFoto(id, index) {
    if (!confirm('Hapus foto ini?')) return;

    fetch(`/laporan_kegiatan/${id}/foto/${index}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).then(response => {
        if (!response.ok) {
            alert('Gagal');
            return;
        }

        const msg = document.createElement('div');
                msg.innerText = 'Foto berhasil dihapus';
                msg.style.position = 'fixed';
                msg.style.top = '20px';
                msg.style.right = '20px';
                msg.style.background = '#16a34a';
                msg.style.color = '#fff';
                msg.style.padding = '10px 15px';
                msg.style.borderRadius = '6px';
                msg.style.zIndex = '9999';

                document.body.appendChild(msg);

                setTimeout(() => {
                    location.reload();
                }, 800);
    });
}

document.addEventListener('DOMContentLoaded', function () {

    const MAX_SIZE = 1 * 1024 * 1024; // 1MB

    const fileGanti = document.getElementById('fileGanti');
    const fileTambah = document.getElementById('fileTambah');

    function validateFile(fileInput) {
        if (!fileInput.files.length) return false;

        const file = fileInput.files[0];

        if (file.size > MAX_SIZE) {
            alert('Ukuran file melebihi 1 MB. Silakan pilih foto yang lebih kecil.');
            fileInput.value = '';
            return false;
        }

        return file;
    }

    if (fileGanti) {
        fileGanti.addEventListener('change', function () {

            const file = validateFile(this);
            if (!file) return;

            let fd = new FormData();
            fd.append('foto', file);

            fetch(`/laporan_kegiatan/${laporanId}/foto/${fotoIndex}/replace`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: fd
            }).then(response => {
                if (!response.ok) {
                    alert('Upload gagal');
                    return;
                }

                const msg = document.createElement('div');
                msg.innerText = 'Foto berhasil diubah';
                msg.style.position = 'fixed';
                msg.style.top = '20px';
                msg.style.right = '20px';
                msg.style.background = '#16a34a';
                msg.style.color = '#fff';
                msg.style.padding = '10px 15px';
                msg.style.borderRadius = '6px';
                msg.style.zIndex = '9999';

                document.body.appendChild(msg);

                setTimeout(() => {
                    location.reload();
                }, 800);
            });
        });
    }

    if (fileTambah) {
        fileTambah.addEventListener('change', function () {

            const file = validateFile(this);
            if (!file) return;

            let fd = new FormData();
            fd.append('foto', file);

            fetch(`/laporan_kegiatan/${laporanId}/foto/tambah`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: fd
            }).then(response => {
                if (!response.ok) {
                    alert('Upload gagal');
                    return;
                }

                const msg = document.createElement('div');
                msg.innerText = 'Foto berhasil ditambahkan';
                msg.style.position = 'fixed';
                msg.style.top = '20px';
                msg.style.right = '20px';
                msg.style.background = '#16a34a';
                msg.style.color = '#fff';
                msg.style.padding = '10px 15px';
                msg.style.borderRadius = '6px';
                msg.style.zIndex = '9999';

                document.body.appendChild(msg);

                setTimeout(() => {
                    location.reload();
                }, 800);
            });
        });
    }
});

</script>

@endsection

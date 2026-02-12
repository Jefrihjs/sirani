@extends('layouts.dashboard')

@section('title', 'Input Laporan Kegiatan')
@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M19.5 14.25V6a2.25 2.25 0 00-2.25-2.25H8.25A2.25 2.25 0 006 6v12a2.25 2.25 0 002.25 2.25h5.25" />
</svg>
@endsection
@section('content')
<div class="container-narrow">

    <div class="form-header">
        <div>
            <h1>Input Laporan Kegiatan</h1>
            <p class="form-subtitle">Tambahkan aktivitas kerja harian ASN</p>
        </div>

        <a href="{{ route('laporan_kegiatan.index') }}" class="link-back">
            ← Kembali
        </a>
    </div>

    <div class="card">
        <form action="{{ route('laporan_kegiatan.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            {{-- Jenis Kegiatan --}}
            <div>
                <label class="form-label">Nama Kegiatan</label>
                <select name="master_kegiatan_id" class="form-input" required>
                    <option value="" disabled selected>-- Pilih Jenis Kegiatan --</option>
                    @foreach($kegiatan as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kegiatan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Grid --}}
            <div class="form-grid-2">
                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Tempat</label>
                    <input type="text" name="tempat" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-input" required>
                </div>
            </div>

            {{-- Uraian --}}
            <div>
                <label class="form-label">Uraian Kegiatan</label>
                <textarea name="uraian" rows="5" class="form-input" required></textarea>
            </div>

            {{-- Foto --}}
            <div>
                <label class="form-label">Foto Kegiatan (min. 2)</label>
                <input type="file" name="foto[]" multiple class="form-input" required>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button class="btn-primary">Simpan Laporan</button>
                <a href="{{ route('laporan_kegiatan.index') }}" class="btn-secondary">Batal</a>
            </div>

        </form>
    </div>

</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Edit Master Kegiatan')

@section('content')

<div class="form-wrapper">

    {{-- HEADER --}}
    <div class="form-header">
        <div>
            <h1>Edit Master Kegiatan</h1>
            <p class="form-subtitle">Perbarui informasi kegiatan Anda</p>
        </div>

        <a href="{{ route('master-kegiatan.index') }}" class="link-back">
            ← Kembali
        </a>
    </div>


    {{-- CARD --}}
    <div class="form-card">

        <form method="POST"
              action="{{ route('master-kegiatan.update', $row->id) }}">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group">
                <label class="form-label">Nama Kegiatan</label>
                <input type="text"
                       name="nama_kegiatan"
                       value="{{ old('nama_kegiatan', $row->nama_kegiatan) }}"
                       class="form-input"
                       required>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="aktif" class="form-input">
                    <option value="1" {{ $row->aktif ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="0" {{ !$row->aktif ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>

                <a href="{{ route('master-kegiatan.index') }}"
                   class="btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection

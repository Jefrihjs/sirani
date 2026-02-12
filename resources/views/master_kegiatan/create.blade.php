@extends('layouts.dashboard')

@extends('layouts.dashboard')

@section('title', 'Tambah Master Kegiatan')

@section('content')

<div class="form-wrapper">

    {{-- HEADER --}}
    <div class="form-header">
        <div>
            <h1>Tambah Master Kegiatan</h1>
            <p class="form-subtitle">Tambahkan jenis kegiatan baru</p>
        </div>

        <a href="{{ route('master-kegiatan.index') }}" class="link-back">
            ← Kembali
        </a>
    </div>


    {{-- CARD --}}
    <div class="form-card">

        <form method="POST" action="{{ route('master-kegiatan.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Kegiatan</label>
                <input type="text"
                       name="nama_kegiatan"
                       class="form-input"
                       placeholder="Contoh: Pengembangan Sistem"
                       required>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="form-group">
                <label class="form-label" style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" name="is_global" value="1">
                    Jadikan sebagai Kegiatan Global (muncul ke semua user)
                </label>
            </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    Simpan Kegiatan
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


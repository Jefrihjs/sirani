@extends('layouts.dashboard')

@section('title', 'Edit Profil ASN')

@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M4.5 20.25a7.5 7.5 0 0115 0" />
</svg>
@endsection

@section('content')

<div class="form-wrapper">

    {{-- HEADER --}}
    <div class="form-header">
        <div>
            <h1>Edit Profil ASN</h1>
            <p class="form-subtitle">Perbarui informasi kepegawaian Anda</p>
        </div>

        <a href="{{ route('profil.asn') }}" class="link-back">
            ← Kembali
        </a>
    </div>


    <div class="form-card">

        <form method="POST"
              action="{{ route('profil.asn.update') }}"
              enctype="multipart/form-data">
            @csrf


            {{-- FOTO PROFIL --}}
            <div class="photo-section">
                @php
                    $photoPath = $user->photo
                        ? storage_path('app/public/' . $user->photo)
                        : null;

                    $photoUrl = $user->photo && file_exists($photoPath)
                        ? asset('storage/' . $user->photo) . '?v=' . filemtime(storage_path('app/public/'.$user->photo))
                        : 'https://ui-avatars.com/api/?size=200&name=' . urlencode($user->name);
                @endphp

                <img src="{{ $photoUrl }}" class="photo-preview">

                <div>
                    <label class="form-label">Foto Profil</label>
                    <input type="file"
                           name="photo"
                           accept="image/png,image/jpeg"
                           class="form-input">
                    <small class="form-hint">
                        JPG / PNG maksimal 2MB
                    </small>
                </div>

            </div>


            {{-- USER READ ONLY --}}
            <div class="form-grid-2 mt-6">

                <div>
                    <label class="form-label">Nama</label>
                    <input type="text"
                           class="form-input input-readonly"
                           value="{{ $user->name }}"
                           disabled>
                </div>

                <div>
                    <label class="form-label">NIP</label>
                    <input type="text"
                           class="form-input input-readonly"
                           value="{{ $user->nip }}"
                           disabled>
                </div>

            </div>


            {{-- DATA ASN --}}
            <div class="form-grid-2 mt-6">

                <div>
                    <label class="form-label">Jabatan</label>
                    <input type="text"
                           name="jabatan"
                           class="form-input"
                           value="{{ old('jabatan', $profile->jabatan ?? '') }}"
                           required>
                </div>

                <div>
                    <label class="form-label">Jenis Jabatan</label>
                    <select name="jenis_jabatan" class="form-input">
                        @php $currentJenis = old('jenis_jabatan', $profile->jenis_jabatan); @endphp
                        <option value="Struktural" {{ $currentJenis === 'Struktural' ? 'selected' : '' }}>Struktural</option>
                        <option value="Fungsional" {{ $currentJenis === 'Fungsional' ? 'selected' : '' }}>Fungsional</option>
                        <option value="Pelaksana" {{ $currentJenis === 'Pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Unit Kerja</label>
                    <input type="text"
                           name="unit_kerja"
                           class="form-input"
                           value="{{ old('unit_kerja', $profile->unit_kerja ?? '') }}"
                           required>
                </div>

                <div>
                    <label class="form-label">Unit Teknis</label>
                    <input type="text"
                           name="unit_teknis"
                           class="form-input"
                           value="{{ old('unit_teknis', $profile->unit_teknis ?? '') }}">
                </div>

                <div>
                    <label class="form-label">Golongan / Ruang</label>
                    <input type="text"
                           name="golongan_ruang"
                           class="form-input"
                           value="{{ old('golongan_ruang', $profile->golongan_ruang ?? '') }}"
                           required>
                </div>

                <div>
                    <label class="form-label">Status Kepegawaian</label>
                    <select name="status_kepegawaian" class="form-input">
                        @foreach (['PNS', 'PPPK'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status_kepegawaian', $profile->status_kepegawaian) === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Atasan Langsung</label>
                    <select name="atasan_id" class="form-input">
                        <option value="">- Pilih Atasan -</option>
                        @foreach ($atasanList as $atasan)
                            <option value="{{ $atasan->id }}"
                                {{ old('atasan_id', $profile->atasan_id) == $atasan->id ? 'selected' : '' }}>
                                {{ $atasan->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>


            {{-- ACTION --}}
            <div class="form-actions mt-8">
                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>

                <a href="{{ route('profil.asn') }}"
                   class="btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection


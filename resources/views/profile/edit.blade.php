@extends('layouts.dashboard')

@section('title', 'Edit Profil ASN')

@section('content')
<h2 class="font-semibold text-xl mb-4">Edit Profil ASN</h2>

<div class="p-6 max-w-4xl mx-auto bg-white shadow rounded-lg">

    <form method="POST"
          action="{{ route('profil.asn.update') }}"
          enctype="multipart/form-data"
          class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div style="display:flex;align-items:center;gap:30px;margin-bottom:30px;">

    {{-- FOTO SAAT INI --}}
    <div>
                @php
            $photoPath = $user->photo
                ? storage_path('app/public/' . $user->photo)
                : null;

            $photoUrl = $user->photo && file_exists($photoPath)
                ? asset('storage/' . $user->photo) . '?v=' . filemtime($photoPath)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
            @endphp

        <img
            src="{{ $photoUrl }}"
            style="
                width:120px;
                height:120px;
                border-radius:50%;
                object-fit:cover;
                border:3px solid #6366f1;
            ">

    </div>

    {{-- INPUT FOTO --}}
    <div>
        <label class="text-sm font-semibold">Foto Profil</label><br>

        <input type="file"
               name="photo"
               accept="image/png,image/jpeg"
               style="margin-top:8px;">

        <div style="font-size:12px;color:#6b7280;margin-top:4px;">
            JPG / PNG, maksimal 2MB
        </div>
    </div>
</div>

        {{-- DATA USER --}}
        <div>
            <label class="text-sm">Nama</label>
            <input type="text"
                   class="w-full bg-gray-100"
                   value="{{ $user->name }}"
                   disabled>
        </div>

        <div>
            <label class="text-sm">NIP</label>
            <input type="text"
                   class="w-full bg-gray-100"
                   value="{{ $user->nip }}"
                   disabled>
        </div>

        {{-- DATA ASN --}}
        <div>
            <label class="text-sm">Jabatan</label>
            <input type="text"
                   name="jabatan"
                   class="w-full"
                   value="{{ old('jabatan', $profile->jabatan) }}"
                   required>
        </div>

        <div>
            <label class="text-sm">Jenis Jabatan</label>
            <select name="jenis_jabatan" class="w-full">
                @foreach (['Struktural','Fungsional','Pelaksana'] as $jenis)
                    <option value="{{ $jenis }}"
                        {{ old('jenis_jabatan', $profile->jenis_jabatan) === $jenis ? 'selected' : '' }}>
                        {{ $jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm">Unit Kerja</label>
            <input type="text"
                   name="unit_kerja"
                   class="w-full"
                   value="{{ old('unit_kerja', $profile->unit_kerja) }}"
                   required>
        </div>

        <div>
            <label class="text-sm">Unit Teknis</label>
            <input type="text"
                   name="unit_teknis"
                   class="w-full"
                   value="{{ old('unit_teknis', $profile->unit_teknis) }}">
        </div>

        <div>
            <label class="text-sm">Golongan / Ruang</label>
            <input type="text"
                   name="golongan_ruang"
                   class="w-full"
                   value="{{ old('golongan_ruang', $profile->golongan_ruang) }}"
                   required>
        </div>

        <div>
            <label class="text-sm">Status Kepegawaian</label>
            <select name="status_kepegawaian" class="w-full">
                @foreach (['PNS', 'PPPK'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status_kepegawaian', $profile->status_kepegawaian) === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm">Atasan Langsung</label>
            <select name="atasan_id" class="w-full">
                <option value="">- Pilih Atasan -</option>
                @foreach($atasanList as $atasan)
                    <option value="{{ $atasan->id }}"
                        @selected($profile->atasan_id == $atasan->id)>
                        {{ $atasan->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TOMBOL --}}
        <div class="mt-8 pt-4 flex gap-3 border-t">
            <button type="submit"
                style="
                    padding:12px 24px;
                    background:green;
                    color:white;
                    font-weight:bold;
                    border:none;
                    cursor:pointer;
                ">
                UPDATE PROFIL
            </button>

            <a href="{{ route('profil.asn') }}"
               style="
                    padding:12px 24px;
                    background:#ccc;
                    color:black;
                    text-decoration:none;
               ">
                BATAL
            </a>
        </div>

    </form>
</div>
@endsection

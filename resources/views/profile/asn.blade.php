@extends('layouts.dashboard')

@section('title', 'Profil ASN')

@section('content')

<h2 class="font-semibold text-xl text-gray-800 mb-4">
    Profil ASN
</h2>

{{-- HEADER PROFIL --}}
<div class="p-6 max-w-4xl mx-auto bg-white shadow rounded-lg
            flex flex-col items-center text-center mb-6">

    {{-- FOTO PROFIL --}}
    <img
        src="{{ $user->photo
            ? asset('storage/' . $user->photo)
            : 'https://ui-avatars.com/api/?size=160&name='.urlencode($user->name) }}"
        style="
            width:140px;
            height:140px;
            border-radius:50%;
            object-fit:cover;
            border:4px solid #6366f1;
            margin-bottom:12px;
        "
        alt="Foto Profil"
    >

    <h3 class="text-xl font-semibold">
        {{ $user->name }}
    </h3>

    <p class="text-gray-500">
        NIP: {{ $user->nip ?? '-' }}
    </p>

    <p class="text-gray-600 mt-1">
        {{ $profile->jabatan ?? '-' }}
    </p>

    <a href="{{ route('profil.asn.edit') }}"
       class="mt-4 px-4 py-2 bg-blue-600 text-white rounded text-sm">
        ✏️ Edit Profil
    </a>
</div>

{{-- DATA ASN --}}
<div class="p-6 max-w-4xl mx-auto bg-white shadow rounded-lg space-y-4">

    <h3 class="text-lg font-semibold mb-2">Data ASN</h3>

    <div>
        <label class="text-sm text-gray-500">Nama</label>
        <p class="font-medium">{{ $user->name }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">NIP</label>
        <p class="font-medium">{{ $user->nip ?? '-' }}</p>
    </div>

    <hr>

    <div>
        <label class="text-sm text-gray-500">Jabatan</label>
        <p>{{ $profile->jabatan ?? '-' }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">Jenis Jabatan</label>
        <p>{{ $profile->jenis_jabatan ?? '-' }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">Unit Kerja</label>
        <p>{{ $profile->unit_kerja ?? '-' }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">Unit Teknis</label>
        <p>{{ $profile->unit_teknis ?? '-' }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">Golongan / Ruang</label>
        <p>{{ $profile->golongan_ruang ?? '-' }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">Status Kepegawaian</label>
        <p>{{ $profile->status_kepegawaian ?? '-' }}</p>
    </div>

    <div>
        <label class="text-sm text-gray-500">Atasan Langsung</label>
        <p>{{ optional($profile->atasan)->name ?? '-' }}</p>
    </div>

</div>
@endsection

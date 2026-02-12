@extends('layouts.dashboard')

@section('title', 'Profil ASN')

@section('icon')
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M4.5 20.25a7.5 7.5 0 0115 0" />
</svg>
@endsection

@section('content')

<div class="page-wrapper">

    {{-- PROFILE HEADER --}}
    <div class="profile-card">

        <div class="profile-avatar">
            <img
                src="{{ auth()->user()->photo
                    ? asset('storage/' . auth()->user()->photo)
                    : 'https://ui-avatars.com/api/?size=200&name=' . urlencode(auth()->user()->name)
                }}"
                alt="Foto Profil">
        </div>

        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p class="profile-nip">NIP: {{ $user->nip }}</p>
            <p class="profile-jabatan">
                {{ $profile->jabatan ?? '-' }}
            </p>

            <a href="{{ route('profil.asn.edit') }}" class="link-cta">
                ✏ Edit Profil
            </a>
        </div>

    </div>


    {{-- DATA ASN --}}
    <div class="card mt-6">

        <h3 class="section-title">Data ASN</h3>

        <div class="profile-grid">

            <div>
                <label>Jenis Jabatan</label>
                <p>{{ $profile->jenis_jabatan ?? '-' }}</p>
            </div>

            <div>
                <label>Unit Kerja</label>
                <p>{{ $profile->unit_kerja ?? '-' }}</p>
            </div>

            <div>
                <label>Unit Teknis</label>
                <p>{{ $profile->unit_teknis ?? '-' }}</p>
            </div>

            <div>
                <label>Golongan / Ruang</label>
                <p>{{ $profile->golongan_ruang ?? '-' }}</p>
            </div>

            <div>
                <label>Status Kepegawaian</label>
                <p>{{ $profile->status_kepegawaian ?? '-' }}</p>
            </div>

            <div>
                <label>Atasan Langsung</label>
                <p>{{ optional($profile->atasan)->name ?? '-' }}</p>
            </div>

        </div>

    </div>

</div>

@endsection


@extends('layouts.dashboard')

@section('title', 'Profil ASN')

@section('content')
{{-- Memanggil Tailwind --}}


<div class="p-4 md:p-10 max-w-5xl mx-auto space-y-8">

    {{-- HEADER PROFIL (CARD ATAS) --}}
    <div class="relative bg-white rounded-[3rem] shadow-sm border border-slate-100 p-8 flex flex-col items-center text-center overflow-hidden">
        {{-- Dekorasi Latar Belakang (Royal Blue Gradient) --}}
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-slate-900 via-blue-900 to-blue-700"></div>
        
        <div class="relative mt-12">
            {{-- FOTO PROFIL --}}
            <div class="relative inline-block">
                <img
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?size=200&background=1e293b&color=fff&name='.urlencode($user->name) }}"
                    class="w-32 h-32 md:w-44 md:h-44 rounded-[2.5rem] object-cover border-8 border-white shadow-2xl transition-transform hover:scale-105 duration-500"
                    alt="Foto Profil"
                >
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 border-4 border-white rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-3xl font-black text-slate-800 tracking-tighter uppercase italic">
                {{ $user->name }}
            </h3>
            <div class="flex flex-wrap justify-center gap-3 mt-4">
                <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-[10px] font-black tracking-[0.2em] uppercase shadow-lg shadow-slate-200">
                    NIP: {{ $user->nip ?? '-' }}
                </span>
                <span class="px-4 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-[10px] font-black tracking-[0.2em] uppercase border border-blue-100">
                    {{ $profile->status_kepegawaian ?? 'ASN PERINTAH' }}
                </span>
            </div>
            <p class="text-slate-500 mt-5 font-bold text-sm tracking-wide max-w-lg mx-auto leading-relaxed uppercase opacity-80">
                {{ $profile->jabatan ?? 'Jabatan Belum Terdefinisi' }}
            </p>
        </div>

        <div class="mt-10 pb-4">
            <a href="{{ route('profil.asn.edit') }}"
               class="inline-flex items-center px-10 py-4 bg-slate-900 hover:bg-blue-700 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-slate-200 active:scale-95 group">
                <svg class="w-4 h-4 mr-3 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                Update Informasi Profil
            </a>
        </div>
    </div>

    {{-- DATA DETAIL (CARD BAWAH) --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 p-8 md:p-14 relative overflow-hidden">
        {{-- Watermark Icon --}}
        <div class="absolute -right-10 -bottom-10 text-slate-50 opacity-50">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
        </div>

        <div class="flex items-center space-x-5 mb-12 border-b border-slate-50 pb-8">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Struktur Organisasi</h3>
                <p class="text-slate-800 text-lg font-black tracking-tighter mt-1 italic">Detail Penempatan & Hierarki</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-10 relative z-10">
            {{-- Item Data --}}
            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all duration-300">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Unit Kerja Utama</label>
                <p class="text-slate-700 font-black text-base tracking-tight group-hover:translate-x-1 transition-transform uppercase italic">{{ $profile->unit_kerja ?? 'DINAS TERKAIT' }}</p>
            </div>

            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all duration-300">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Bidang / Unit Teknis</label>
                <p class="text-slate-700 font-black text-base tracking-tight group-hover:translate-x-1 transition-transform uppercase italic">{{ $profile->unit_teknis ?? 'SUB BIDANG' }}</p>
            </div>

            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all duration-300">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Klasifikasi Jabatan</label>
                <p class="text-slate-700 font-black text-base tracking-tight group-hover:translate-x-1 transition-transform uppercase italic">{{ $profile->jenis_jabatan ?? 'FUNGSIONAL' }}</p>
            </div>

            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all duration-300">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pangkat / Golongan</label>
                <p class="text-slate-700 font-black text-base tracking-tight group-hover:translate-x-1 transition-transform uppercase italic">{{ $profile->golongan_ruang ?? 'III/A - PENATA MUDA' }}</p>
            </div>

            {{-- Card Atasan Spesial --}}
            <div class="md:col-span-2 mt-4 p-8 bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-blue-900/10 flex items-center justify-between border border-white/5 group overflow-hidden relative">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-3">Laporan Atasan Langsung</label>
                    <p class="text-white font-black text-2xl tracking-tighter italic uppercase underline decoration-blue-500 decoration-4 underline-offset-8">
                        {{ optional($profile->atasan)->name ?? 'ADMINISTRATOR' }}
                    </p>
                    <div class="flex items-center mt-6 text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                        <span class="bg-blue-600 w-2 h-2 rounded-full mr-2 animate-pulse"></span>
                        NIP: {{ optional($profile->atasan)->nip ?? '19xxxxxxxxxxxxxx' }}
                    </div>
                </div>
                <div class="hidden sm:block opacity-20 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700">
                    <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
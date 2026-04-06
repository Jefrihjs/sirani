@extends('layouts.dashboard')

@section('title', 'Profil ASN')

@section('content')
{{-- Memanggil Tailwind --}}


<div class="p-4 md:p-10 max-w-5xl mx-auto space-y-8">

    {{-- CARD HEADER: IDENTITAS UTAMA --}}
    <div class="relative bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden group">
        {{-- Aksen Gradasi Biru Royal (MENGGANTIKAN EMERALD) --}}
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-slate-900 via-blue-900 to-blue-700"></div>
        
        <div class="relative pt-12 pb-8 px-8 flex flex-col md:flex-row items-center md:items-end gap-6">
            {{-- Foto Profil --}}
            <div class="relative">
                <img
                    src="{{ auth()->user()->photo
                        ? asset('storage/' . auth()->user()->photo) . '?v=' . time()
                        : 'https://ui-avatars.com/api/?size=200&background=1e293b&color=fff&name=' . urlencode(auth()->user()->name)
                    }}"
                    class="w-32 h-32 md:w-44 md:h-44 rounded-3xl object-cover border-4 border-white shadow-2xl transition-transform duration-500 group-hover:scale-105"
                    alt="Foto Profil">
                {{-- Indikator Biru --}}
                <div class="absolute bottom-2 right-2 w-7 h-7 bg-blue-600 border-4 border-white rounded-full shadow-lg"></div>
            </div>

            {{-- Info Nama & Jabatan --}}
            <div class="flex-1 text-center md:text-left mb-2">
                {{-- Kita ganti text-slate-800 menjadi text-white agar kontras dengan background biru --}}
                <h2 class="text-3xl md:text-4xl font-black text-white tracking-tighter italic uppercase drop-shadow-md">
                    {{ $user->name }}
                </h2>
                
                <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-3">
                    {{-- Badge NIP dibuat lebih kontras --}}
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest rounded-lg border border-white/30">
                        NIP: {{ $user->nip }}
                    </span>
                    {{-- Badge Status --}}
                    <span class="px-3 py-1 bg-blue-400 text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm">
                        {{ $profile->status_kepegawaian ?? 'PNS' }}
                    </span>
                </div>
                
                {{-- Jabatan diletakkan di bawah agar tidak menumpuk dengan nama --}}
                <p class="text-blue-100 font-bold mt-4 text-lg uppercase tracking-wider opacity-90">
                    {{ $profile->jabatan ?? 'PRANATA KOMPUTER MUDA' }}
                </p>
            </div>

            {{-- Tombol Edit --}}
            <div class="pb-2">
                <a href="{{ route('profil.asn.edit') }}" 
                   class="inline-flex items-center px-8 py-4 bg-slate-900 hover:bg-blue-700 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all shadow-xl active:scale-95 group">
                    <svg class="w-4 h-4 mr-3 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Update Profil
                </a>
            </div>
        </div>
    </div>

    {{-- CARD BODY: DETAIL DATA ASN --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-14 relative overflow-hidden">
        {{-- Watermark Background --}}
        <div class="absolute -right-10 -bottom-10 text-slate-50 opacity-50">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
        </div>

        <div class="flex items-center gap-4 mb-12 border-b border-slate-50 pb-8">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Informasi Kepegawaian</h3>
                <p class="text-slate-800 text-lg font-black tracking-tighter mt-1 italic">Detail Penempatan & Struktur</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-10 relative z-10">
            
            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Jenis Jabatan</label>
                <p class="text-slate-700 font-black text-base uppercase italic tracking-tight">{{ $profile->jenis_jabatan ?? '-' }}</p>
            </div>

            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Unit Kerja Utama</label>
                <p class="text-slate-700 font-black text-base uppercase italic tracking-tight">{{ $profile->unit_kerja ?? '-' }}</p>
            </div>

            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Bidang / Unit Teknis</label>
                <p class="text-slate-700 font-black text-base uppercase italic tracking-tight">{{ $profile->unit_teknis ?? '-' }}</p>
            </div>

            <div class="group border-l-4 border-slate-100 pl-6 hover:border-blue-600 transition-all">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Golongan / Ruang</label>
                <p class="text-slate-700 font-black text-base uppercase italic tracking-tight">{{ $profile->golongan_ruang ?? '-' }}</p>
            </div>

            <div class="group md:col-span-2 mt-4">
                <div class="p-8 bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-blue-900/10 flex items-center justify-between border border-white/5 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-3">Pejabat Penilai (Atasan)</label>
                        <p class="text-white font-black text-2xl tracking-tighter italic uppercase underline decoration-blue-500 decoration-4 underline-offset-8">
                            {{ optional($profile->atasan)->name ?? '-' }}
                        </p>
                        <div class="flex items-center mt-6 text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                            <span class="bg-blue-600 w-2 h-2 rounded-full mr-2 animate-pulse"></span>
                            NIP Atasan: {{ optional($profile->atasan)->nip ?? '-' }}
                        </div>
                    </div>
                    <div class="hidden sm:block opacity-20 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700">
                         <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
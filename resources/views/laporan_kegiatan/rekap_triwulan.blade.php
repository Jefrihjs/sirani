@extends('layouts.dashboard')

@section('title', 'Laporan Triwulan')

@section('content')
{{-- Memanggil Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-amber-500 rounded-2xl text-white shadow-xl shadow-amber-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Rekap Triwulan {{ $triwulan }}</h1>
                <p class="text-slate-400 text-sm font-medium mt-1">Periode Tahun {{ $tahun }} • Evaluasi Kinerja Berkala</p>
            </div>
        </div>

        {{-- Export Button --}}
        <a href="{{ route('rekap.triwulan.export', request()->query()) }}" 
           class="inline-flex items-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-100 transition-all transform active:scale-95 text-xs uppercase tracking-widest group">
            <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export Excel
        </a>
    </div>

    {{-- FILTER CONTROL --}}
    <div class="bg-slate-900 p-6 rounded-[2rem] shadow-xl shadow-slate-200">
        <form method="GET" action="{{ route('rekap.triwulan') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            {{-- Triwulan --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Periode</label>
                <div class="relative">
                    <select name="triwulan" class="w-full appearance-none pl-4 pr-10 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm font-bold text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all cursor-pointer">
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}" {{ $triwulan == $i ? 'selected' : '' }}>Triwulan {{ $i }}</option>
                        @endfor
                    </select>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            {{-- Tahun --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Kalender</label>
                <input type="number" name="tahun" value="{{ $tahun }}" 
                       class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm font-bold text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all">
            </div>

            {{-- Kegiatan --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Filter Kegiatan</label>
                <div class="relative">
                    <select name="kegiatan_id" class="w-full appearance-none pl-4 pr-10 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm font-bold text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-all cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach ($daftarKegiatan as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ $kegiatanId == $kegiatan->id ? 'selected' : '' }}>
                                {{ $kegiatan->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full px-6 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-black rounded-xl transition-all shadow-lg shadow-amber-900/20 active:scale-95 text-[11px] uppercase tracking-widest">
                Tampilkan Data
            </button>
        </form>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-20 text-center">No</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-48">Tanggal</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rincian & Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-48 text-center">Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($data as $i => $row)
                    <tr class="hover:bg-amber-50/30 transition-colors group">
                        <td class="px-8 py-6 text-sm font-bold text-slate-400 text-center">{{ $i + 1 }}</td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="text-slate-700 font-extrabold text-sm">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</span>
                                <span class="text-[10px] font-bold text-amber-500 uppercase mt-0.5 tracking-tighter">Hari Ke-{{ \Carbon\Carbon::parse($row->tanggal)->dayOfYear }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="space-y-1">
                                <div class="inline-flex px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-wider border border-amber-100 mb-1">
                                    {{ $row->kegiatan->nama_kegiatan ?? '-' }}
                                </div>
                                <p class="text-slate-600 text-sm font-bold leading-snug group-hover:text-amber-700 transition-colors line-clamp-2">
                                    {{ $row->uraian }}
                                </p>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex items-center px-3 py-1 bg-slate-50 text-slate-500 text-[11px] font-bold rounded-full group-hover:bg-white transition-all shadow-sm">
                                <svg class="w-3 h-3 mr-1.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $row->tempat ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-6 bg-slate-50 rounded-full mb-4 text-slate-200">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                                </div>
                                <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-[10px]">Data Triwulan Belum Tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
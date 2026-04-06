@extends('layouts.dashboard')

@section('title', 'Laporan Tahunan')

@section('content')
{{-- Memanggil Tailwind --}}


<div class="p-4 md:p-10 max-w-7xl mx-auto space-y-8">

    {{-- HEADER & EXPORT --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-violet-600 rounded-[1.5rem] text-white shadow-2xl shadow-violet-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 7v12a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase">Rekap Tahunan {{ $tahun }}</h1>
                <p class="text-slate-400 font-medium mt-1">Arsip digital seluruh aktivitas kerja ASN dalam satu tahun anggaran</p>
            </div>
        </div>
        
        <a href="{{ route('rekap.tahunan.export', request()->query()) }}" 
           class="inline-flex items-center px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-lg shadow-emerald-100 transition-all transform active:scale-95 group text-xs uppercase tracking-widest">
            <svg class="w-5 h-5 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export to Excel (.xlsx)
        </a>
    </div>

    {{-- STATS SUMMARY (PENYEGAR 2026) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-violet-600 to-indigo-700 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-100">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Periode Aktif</span>
            <h2 class="text-3xl font-black mt-2 tracking-tighter">{{ $tahun }}</h2>
            <div class="mt-4 flex items-center text-xs font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                Sesuai Tahun Anggaran
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col justify-center">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Volume Kegiatan</span>
            <h2 class="text-3xl font-black text-slate-800 mt-2 tracking-tighter">{{ count($data) }} <small class="text-xs text-slate-400 font-bold uppercase">Aktivitas</small></h2>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col justify-center">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Laporan</span>
            <h2 class="text-xl font-black text-emerald-500 mt-2 tracking-tight uppercase">Tersinkronisasi</h2>
        </div>
    </div>

    {{-- FILTER PANEL --}}
    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-xl shadow-slate-200 overflow-hidden relative">
        {{-- Dekorasi Latar --}}
        <div class="absolute right-0 top-0 w-32 h-32 bg-violet-500/10 rounded-full blur-3xl"></div>

        <form method="GET" action="{{ route('rekap.tahunan') }}" class="flex flex-wrap items-end gap-6 relative z-10">
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Tahun Kalender</label>
                <input type="number" name="tahun" value="{{ $tahun }}" 
                       class="w-32 px-5 py-4 bg-slate-800 border border-slate-700 rounded-2xl text-sm font-bold text-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 outline-none transition-all">
            </div>

            <div class="flex-1 min-w-[280px] space-y-3">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Kategori Khusus</label>
                <div class="relative">
                    <select name="kegiatan_id" 
                            class="w-full appearance-none pl-5 pr-12 py-4 bg-slate-800 border border-slate-700 rounded-2xl text-sm font-bold text-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 outline-none transition-all cursor-pointer">
                        <option value="">-- Semua Jenis Kegiatan --</option>
                        @foreach ($daftarKegiatan as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ $kegiatanId == $kegiatan->id ? 'selected' : '' }}>
                                {{ $kegiatan->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="px-10 py-4 bg-violet-600 hover:bg-violet-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-violet-900/20 active:scale-95 text-xs uppercase tracking-[0.2em]">
                Filter Data
            </button>
        </form>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] w-24 text-center">Urutan</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] w-56 text-center">Waktu Eksekusi</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-left">Deskripsi Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($data as $i => $row)
                    <tr class="hover:bg-violet-50/30 transition-all duration-300 group">
                        <td class="px-8 py-8 text-sm font-bold text-slate-400 text-center group-hover:text-violet-600 transition-colors">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        
                        <td class="px-6 py-8">
                            <div class="flex flex-col items-center">
                                <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-2xl text-[11px] font-black tracking-tight group-hover:bg-white transition-all shadow-sm">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-8">
                            <div class="space-y-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-violet-50 text-violet-600 text-[10px] font-black border border-violet-100 uppercase tracking-widest">
                                    {{ $row->kegiatan->nama_kegiatan }}
                                </span>
                                <p class="text-slate-600 text-sm leading-relaxed font-medium group-hover:text-slate-900 transition-colors">
                                    {{ $row->uraian }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-8 bg-slate-50 rounded-full mb-6">
                                    <svg class="w-16 h-16 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Arsip Kosong</h3>
                                <p class="text-slate-400 text-xs mt-2 font-medium italic">Tidak ditemukan data rekapitulasi pada tahun yang dipilih.</p>
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
@extends('layouts.dashboard')

@section('title', 'Laporan Kegiatan')

@section('content')
{{-- Memastikan Tailwind Aktif --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-4 md:p-10 max-w-7xl mx-auto space-y-8">

    {{-- ALERT NOTIFIKASI --}}
    @if (session('success'))
        <div class="flex items-center p-5 mb-8 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl shadow-sm animate-fade-in">
            <div class="ml-3 text-[10px] font-black text-emerald-800 uppercase tracking-[0.2em]">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- HEADER & FILTER PANEL --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic">
                Log <span class="text-blue-600">{{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}</span> {{ $tahun }}
            </h1>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.3em] mt-1">Manajemen aktivitas harian pegawai</p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            {{-- Filter Bulan Modern --}}
            <form method="GET" class="relative group">
                <select name="bulan" onchange="this.form.submit()" 
                    class="appearance-none pl-6 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-600 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                    @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </form>

            <a href="{{ route('laporan_kegiatan.create') }}" 
               class="inline-flex items-center px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-100 transition-all transform active:scale-95 text-[10px] uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buat Laporan
            </a>
        </div>
    </div>

    {{-- TIGA KARTU STATISTIK BULANAN (DINAMIS) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- KARTU 1: TOTAL MENIT --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] relative z-10">Total Durasi</span>
            <div class="flex items-baseline gap-2 mt-2 relative z-10">
                <h2 class="text-3xl font-black text-slate-800 tracking-tighter">{{ number_format($data->sum('durasi_menit'), 0, ',', '.') }}</h2>
                <small class="text-blue-600 font-black uppercase text-[10px] italic">Menit</small>
            </div>
        </div>

        {{-- KARTU 2: JUMLAH LAPORAN --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] relative z-10">Volume Laporan</span>
            <div class="flex items-baseline gap-2 mt-2 relative z-10">
                <h2 class="text-3xl font-black text-slate-800 tracking-tighter">{{ $data->count() }}</h2>
                <small class="text-emerald-600 font-black uppercase text-[10px] italic">Dokumen</small>
            </div>
        </div>

        {{-- KARTU 3: RATA-RATA HARIAN --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] relative z-10">Rata-rata Durasi</span>
            <div class="flex items-baseline gap-2 mt-2 relative z-10">
                <h2 class="text-3xl font-black text-slate-800 tracking-tighter">
                    {{ $data->count() > 0 ? number_format($data->sum('durasi_menit') / $data->count(), 0) : 0 }}
                </h2>
                <small class="text-amber-600 font-black uppercase text-[10px] italic">Min / Laporan</small>
            </div>
        </div>
    </div>

    {{-- DATA TABLE MODERN --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] w-32 text-center">Tanggal</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Detail Aktivitas</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] w-56 text-center">Waktu & Lokasi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-right w-44">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($data as $row)
                    <tr class="hover:bg-blue-50/30 transition-all duration-300 group">
                        {{-- TANGGAL --}}
                        <td class="px-8 py-6 text-center">
                            <div class="bg-slate-50 rounded-2xl p-2.5 border border-slate-100 group-hover:bg-white transition-all">
                                <span class="block text-xl font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($row->tanggal)->format('d') }}</span>
                                <span class="block text-[9px] font-black uppercase tracking-widest mt-1 text-blue-500">{{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->translatedFormat('M') }}</span>
                            </div>
                        </td>
                        
                        {{-- RINCIAN --}}
                        <td class="px-6 py-6">
                            <div class="max-w-md space-y-1">
                                <p class="text-slate-700 font-black text-sm uppercase italic tracking-tight group-hover:text-blue-600 transition-colors">{{ $row->kegiatan->nama_kegiatan }}</p>
                                <p class="text-slate-400 text-[11px] font-medium leading-relaxed line-clamp-1 group-hover:line-clamp-none transition-all">{{ $row->uraian }}</p>
                            </div>
                        </td>

                        {{-- WAKTU & TEMPAT --}}
                        <td class="px-6 py-6 text-center">
                            <div class="inline-flex flex-col items-center gap-1.5">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black tracking-widest border border-blue-100 uppercase italic">
                                    {{ $row->jam_mulai }} - {{ $row->jam_selesai }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2.5"/></svg>
                                    {{ $row->tempat }}
                                </span>
                            </div>
                        </td>

                        {{-- AKSI --}}
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                <a href="{{ route('laporan_kegiatan.pdf', $row->id) }}" target="_blank" class="p-2.5 bg-slate-100 text-slate-500 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </a>
                                <a href="{{ route('laporan_kegiatan.edit', $row->id) }}" class="p-2.5 bg-slate-100 text-slate-500 hover:bg-amber-500 hover:text-white rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('laporan_kegiatan.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-slate-100 text-slate-500 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic leading-relaxed">Belum ada laporan kegiatan<br>pada bulan yang dipilih.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
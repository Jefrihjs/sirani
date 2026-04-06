@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
{{-- Memanggil Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('chartProduktivitas');
    
    if (ctx) {
        // Hapus instance chart lama jika ada (mencegah error saat pindah bulan)
        let chartStatus = Chart.getChart("chartProduktivitas");
        if (chartStatus != undefined) {
            chartStatus.destroy();
        }

        // Buat gradasi warna biru modern
        const chartCtx = ctx.getContext('2d');
        const gradient = chartCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, '#3b82f6'); // Blue 600
        gradient.addColorStop(1, '#6366f1'); // Indigo 500

        new Chart(chartCtx, {
            type: 'bar',
            data: {
                labels: ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'],
                datasets: [{
                    label: 'Total Menit',
                    data: @json($dataGrafik), // Data dari Controller
                    backgroundColor: gradient,
                    hoverBackgroundColor: '#1e293b',
                    borderRadius: 15,
                    borderSkipped: false,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        backgroundColor: '#0f172a',
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 13, weight: 'bold' },
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: (context) => context.raw + ' MENIT'
                        }
                    }
                },
                scales: {
                    x: { 
                        grid: { display: false }, 
                        ticks: { 
                            font: { size: 9, weight: '800' }, 
                            color: '#94a3b8' 
                        } 
                    },
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: { 
                            font: { size: 9, weight: '800' }, 
                            color: '#cbd5e1',
                            stepSize: 1000,
                            callback: v => v >= 1000 ? (v/1000) + 'k' : v
                        }
                    }
                }
            }
        });
    }
});
</script>
<div class="p-6 md:p-10 max-w-7xl mx-auto space-y-10 text-slate-800">

    {{-- HERO SECTION: DENGAN FILTER BULAN RAMPING --}}
    <div class="relative group overflow-hidden bg-slate-900 rounded-[3rem] shadow-2xl shadow-blue-900/20 transition-all duration-500">
        {{-- Dekorasi Cahaya Latar --}}
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] group-hover:bg-blue-500/30 transition-all"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-[80px]"></div>

        <div class="relative z-10 p-10 md:p-16 flex flex-col md:flex-row md:items-center justify-between gap-10">
            <div class="space-y-6">
               <div class="flex items-center gap-4">
                {{-- Badge SISTEM TERKONEKSI - Kunci Tinggi 32px --}}
                <div class="flex items-center" style="height: 32px;">
                    <div class="inline-flex items-center h-full px-4 bg-blue-500/10 border border-blue-500/20 rounded-full text-[10px] font-black uppercase tracking-[0.3em] text-blue-400">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                        Sistem Terkoneksi
                    </div>
                </div>
                
                {{-- WIDGET PILIH BULAN - Kunci Tinggi 32px --}}
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center m-0" style="height: 32px;">
                    <div class="relative h-full">
                        <select name="bulan" onchange="this.form.submit()" 
                            class="appearance-none h-full pl-4 pr-10 bg-white/5 border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 focus:border-blue-500 outline-none transition-all cursor-pointer hover:bg-white/10"
                            style="line-height: 1;">
                            @foreach ([1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'] as $num => $nama)
                                <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }} class="bg-slate-900 text-white">{{ $nama }}</option>
                            @endforeach
                        </select>
                        {{-- Ikon panah --}}
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-none">
                    Halo, <span class="bg-gradient-to-r from-blue-400 to-indigo-300 bg-clip-text text-transparent italic">{{ auth()->user()->name }}</span>! 👋
                </h1>
                <p class="text-slate-400 font-bold text-sm md:text-base uppercase tracking-widest opacity-80 italic">
                    Analisis Kinerja: <span class="text-blue-400">{{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }} {{ $tahun }}</span>
                </p>
            </div>

            <div class="shrink-0">
                <a href="{{ route('laporan_kegiatan.create') }}" 
                   class="inline-flex items-center px-10 py-5 bg-blue-600 hover:bg-white text-white hover:text-blue-600 font-black rounded-[2rem] shadow-xl shadow-blue-600/20 transition-all transform active:scale-95 uppercase tracking-[0.2em] text-xs border-2 border-transparent hover:border-blue-600 group/btn">
                    <svg class="w-5 h-5 mr-3 group-hover/btn:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Input Laporan
                </a>
            </div>
        </div>
    </div>

    {{-- STATS GRID: DATA MENGIKUTI BULAN YG DIPILIH --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- CAPAIAN KINERJA --}}
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 relative group hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Capaian Kinerja</span>
                <div class="flex items-baseline gap-2 mt-4">
                    <h2 class="text-5xl font-black text-slate-900 tracking-tighter">{{ number_format($totalMenit, 0, ',', '.') }}</h2>
                    <small class="text-blue-600 font-black uppercase text-xs italic tracking-widest">Menit</small>
                </div>
                <div class="mt-8 space-y-4">
                    <div class="w-full h-4 bg-slate-50 rounded-full p-1 border border-slate-100">
                        <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-500 rounded-full shadow-lg shadow-blue-200" style="width: {{ min($persenKPI, 100) }}%"></div>
                    </div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">
                        Progres: <span class="text-blue-600 font-black">{{ $persenKPI }}%</span> Target Bulan Ini
                    </p>
                </div>
            </div>
        </div>

        {{-- TOTAL DOKUMEN --}}
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
             <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
             <div class="relative z-10">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Dokumen</span>
                <div class="flex items-center gap-6 mt-6">
                    <div class="p-5 bg-emerald-500 text-white rounded-[1.5rem] shadow-xl shadow-emerald-200 transform group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-5xl font-black text-slate-900 tracking-tighter">{{ $jumlahLaporan }}</h2>
                        <p class="text-emerald-600 text-[10px] font-black uppercase tracking-widest mt-1 italic">Arsip {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}</p>
                    </div>
                </div>
             </div>
        </div>

        {{-- STATUS PRODUCTIVITY --}}
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:shadow-xl hover:-translate-y-1 transition-all duration-500 flex flex-col justify-center overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
            <div class="relative z-10 text-center md:text-left">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Status Kerja</span>
                <div class="mt-6">
                    <span class="inline-flex px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] {{ $badgeClass }} shadow-lg ring-4 ring-white">
                        <span class="w-2 h-2 rounded-full mr-2 bg-current animate-pulse"></span>
                        {{ $status }}
                    </span>
                    <p class="mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">Produktivitas periode <br> bulan yang dipilih.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- BOTTOM AREA: LOG & CHART --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- LOG AKTIVITAS --}}
        <div class="lg:col-span-1 bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Aktivitas Terakhir</h3>
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
            </div>
            <div class="space-y-10">
                @forelse ($kegiatanTerakhir as $item)
                <div class="relative pl-10 group cursor-default">
                    <div class="absolute left-0 top-0 h-full w-[2px] bg-slate-100 group-hover:bg-blue-200 transition-colors"></div>
                    <div class="absolute -left-[5px] top-1 w-3 h-3 bg-white border-2 border-blue-600 rounded-full shadow-md transform group-hover:scale-125 transition-transform"></div>
                    <div class="space-y-2">
                        <p class="text-sm font-black text-slate-800 leading-snug group-hover:text-blue-600 transition-colors uppercase italic tracking-tight">{{ $item->nama_kegiatan }}</p>
                        <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2.5"/></svg>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M') }}</span>
                            <span class="px-2 py-0.5 bg-slate-50 rounded border border-slate-100">{{ $item->durasi_menit }} Min</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest italic">Kosong.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- GRAFIK MODERN --}}
        <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 flex flex-col group">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
                <div>
                    <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.3em]">Visualisasi Kinerja Tahunan</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Perbandingan Menit Kerja per Bulan</p>
                </div>
                <div class="px-4 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl uppercase tracking-widest shadow-lg shadow-blue-200">
                    Tahun {{ $tahun }}
                </div>
            </div>
            <div class="flex-1 min-h-[350px] relative">
                <canvas id="chartProduktivitas"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
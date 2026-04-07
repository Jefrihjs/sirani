@extends('layouts.dashboard')

@section('title', 'Laporan Kegiatan')

@section('content')
{{-- Memastikan Tailwind Aktif --}}


<div class="p-4 md:p-10 max-w-7xl mx-auto space-y-8">

    {{-- ALERT NOTIFIKASI SWEETALERT --}}
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                borderRadius: '20px',
                customClass: {
                    popup: 'rounded-[2rem] border-b-4 border-emerald-500',
                    title: 'font-black text-emerald-800 tracking-widest'
                }
            });
        });
    </script>
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
            <form method="GET" class="relative group m-0">
                <select name="bulan" onchange="this.form.submit()" 
                    class="appearance-none h-[52px] pl-6 pr-12 bg-slate-50 border border-slate-200 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-600 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                    @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="tahun" value="{{ $tahun }}">
            </form>

            {{-- Tombol Buat Laporan --}}
            <a href="{{ route('laporan_kegiatan.create') }}" 
            class="inline-flex items-center justify-center h-[52px] px-8 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-100 transition-all transform active:scale-95 text-[10px] uppercase tracking-widest">
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
                            {{-- Menggunakan grid dengan 3 kolom yang ukurannya sama persis --}}
                            <div class="grid grid-cols-3 gap-2 w-fit ml-auto items-center">
                                
                                {{-- TOMBOL CETAK --}}
                                <a href="{{ route('laporan_kegiatan.pdf', $row->id) }}" target="_blank" 
                                class="flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition-all border border-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </a>

                                {{-- TOMBOL EDIT --}}
                                <a href="{{ route('laporan_kegiatan.edit', $row->id) }}" 
                                class="flex items-center justify-center w-9 h-9 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>

                                {{-- TOMBOL HAPUS --}}
                                {{-- Form kita buat 'm-0' dan 'p-0' agar tidak ada spasi tambahan --}}
                                <form action="{{ route('laporan_kegiatan.destroy', $row->id) }}" method="POST" class="m-0 p-0 inline-flex form-hapus">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="konfirmasiHapus(this, event)"
                                            class="flex items-center justify-center w-9 h-9 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all border border-rose-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
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
<x-slot name="scripts">
<script>
function konfirmasiHapus(button, event) {
    event.preventDefault(); // Menghentikan form agar tidak langsung kirim
    const form = button.closest('.form-hapus');
    
    // Memanggil Swal yang sudah di-load di Head
    Swal.fire({
        title: 'Hapus Laporan?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        borderRadius: '20px',
        customClass: {
            popup: 'rounded-[2rem]',
            confirmButton: 'rounded-xl font-black uppercase text-[10px] tracking-widest px-6 py-3',
            cancelButton: 'rounded-xl font-black uppercase text-[10px] tracking-widest px-6 py-3'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
}
</script>
</x-slot>
@endsection

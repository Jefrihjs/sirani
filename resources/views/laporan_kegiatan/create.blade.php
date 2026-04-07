@extends('layouts.dashboard')

@section('title', 'Input Laporan Kegiatan')

@section('content')
{{-- Memanggil Library Kalender Modern --}}
<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
<script src="{{ asset('js/flatpickr.js') }}"></script>


<div class="max-w-4xl mx-auto py-8 px-4">
    
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-600 rounded-2xl text-white shadow-lg shadow-blue-200">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25V6a2.25 2.25 0 00-2.25-2.25H8.25A2.25 2.25 0 006 6v12a2.25 2.25 0 002.25 2.25h5.25" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Input Laporan</h1>
                <p class="text-sm text-gray-500 font-medium">Dokumentasikan aktivitas harian ASN</p>
            </div>
        </div>
        <a href="{{ route('laporan_kegiatan.index') }}" class="text-sm font-semibold text-gray-400 hover:text-blue-600 transition-colors flex items-center group">
            <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('laporan_kegiatan.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="p-6 md:p-10 space-y-8">
            @csrf

            @if ($errors->any())
                <div class="p-4 mb-6 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl shadow-sm">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 text-rose-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[10px] font-black text-rose-800 uppercase tracking-widest">Ada kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside text-[9px] font-bold text-rose-600 uppercase tracking-tighter">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">
                <div class="flex items-center space-x-2 pb-2 border-b border-gray-100">
                    <span class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-bold uppercase tracking-tighter">01</span>
                    <h3 class="font-bold text-gray-400 uppercase tracking-widest text-[10px]">Informasi Aktivitas</h3>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Jenis Kegiatan</label>
                    <select name="master_kegiatan_id" class="w-full px-4 py-3.5 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none bg-gray-50/30 transition-all cursor-pointer" required>
                        <option value="" disabled selected>-- Pilih Jenis Kegiatan --</option>
                        @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Tanggal Pelaksanaan</label>
                        <div class="relative">
                            <input type="text" name="tanggal" id="datepicker" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3.5 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-500/10 outline-none bg-white transition-all cursor-pointer" required>
                            <svg class="w-5 h-5 absolute right-4 top-3.5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 7v12a2.25 2.25 0 002.25 2.25z"/></svg>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Tempat / Lokasi</label>
                        <input type="text" name="tempat" placeholder="Contoh: Kantor Dinas" class="w-full px-4 py-3.5 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-500/10 outline-none bg-gray-50/30 transition-all" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Jam Mulai</label>
                        <input type="text" name="jam_mulai" id="timepicker_start" class="w-full px-4 py-3.5 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-500/10 outline-none bg-white transition-all cursor-pointer" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Jam Selesai</label>
                        <input type="text" name="jam_selesai" id="timepicker_end" class="w-full px-4 py-3.5 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-500/10 outline-none bg-white transition-all cursor-pointer" required>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center space-x-2 pb-2 border-b border-gray-100">
                    <span class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-bold uppercase tracking-tighter">02</span>
                    <h3 class="font-bold text-gray-400 uppercase tracking-widest text-[10px]">Uraian & Bukti</h3>
                </div>

                <div class="space-y-2">
                    <label class="font-black text-[11px] uppercase tracking-widest text-slate-600">
                        Uraian Deskripsi Kegiatan
                    </label>
                    <textarea 
                        name="uraian" 
                        rows="6" 
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium text-slate-700 placeholder:text-slate-400"
                        placeholder="Tuliskan detail pekerjaan Bapak/Ibu di sini..."></textarea>
                    <p class="text-[9px] text-slate-400 italic">Tips: Gunakan 'Enter' untuk memisahkan antar paragraf agar laporan lebih rapi.</p>
                </div>

                @error('uraian')
                    <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter">{{ $message }}</p>
                @enderror
                
                <div class="space-y-2">
                    <label class="font-black text-[11px] uppercase tracking-widest text-slate-600">Dokumentasi Foto (Minimal 1)</label>
                    <input type="file" name="foto[]" multiple 
                        class="w-full px-4 py-3 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all">
                    <p class="text-[9px] text-slate-400 font-bold italic uppercase tracking-tighter">* Bapak/Ibu bisa pilih lebih dari 1 foto sekaligus</p>
                </div>
            </div>

            <div class="pt-6 flex items-center justify-end space-x-4 border-t border-gray-50">
                <button type="reset" class="px-6 py-3 text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Reset</button>
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-200 transition-all uppercase tracking-[0.2em] text-[12px]">
                    Simpan Laporan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        label.innerText = input.files.length > 0 ? input.files.length + ' Foto terpilih' : 'Klik untuk pilih foto';
    }

    // Inisialisasi Flatpickr (Kalender Modern)
    flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        disableMobile: true
    });

    const timeConfig = {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        disableMobile: true
    };
    
    flatpickr("#timepicker_start", timeConfig);
    flatpickr("#timepicker_end", timeConfig);
</script>
@endsection
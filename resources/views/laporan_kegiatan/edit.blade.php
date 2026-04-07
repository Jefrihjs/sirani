@extends('layouts.dashboard')

@section('title', 'Edit Laporan')

@section('content')
{{-- Memastikan Tailwind Aktif --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-4 md:p-10 max-w-5xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-600 rounded-2xl text-white shadow-lg shadow-blue-200">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Perbarui Laporan</h1>
                <p class="text-sm text-slate-500 font-medium leading-tight">Sesuaikan detail dokumentasi aktivitas Anda</p>
            </div>
        </div>
        <a href="{{ route('laporan_kegiatan.index', [
                'bulan' => date('m', strtotime($laporan->tanggal)), 
                'tahun' => date('Y', strtotime($laporan->tanggal))
            ]) }}" 
        class="group flex items-center text-sm font-bold text-slate-400 hover:text-blue-600 transition-all">
            <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        
        {{-- Validasi Error --}}
        @if ($errors->any())
            <div class="m-8 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl">
                <ul class="text-xs font-bold text-rose-700 uppercase tracking-wider space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('laporan_kegiatan.update', $laporan->id) }}" enctype="multipart/form-data" class="p-8 md:p-12 space-y-10">
            @csrf
            @method('PUT')

            {{-- GRID INPUT UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Jenis Kegiatan</label>
                    <div class="relative">
                        <select name="master_kegiatan_id" class="w-full appearance-none px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 cursor-pointer" required>
                            @foreach ($kegiatan as $k)
                                <option value="{{ $k->id }}" {{ old('master_kegiatan_id', $laporan->master_kegiatan_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tanggal Eksekusi</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $laporan->tanggal) }}" 
                           class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $laporan->jam_mulai) }}" 
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 text-center" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $laporan->jam_selesai) }}" 
                               class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 text-center" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Lokasi / Tempat</label>
                    <input type="text" name="tempat" value="{{ old('tempat', $laporan->tempat) }}" 
                           class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Uraian Pekerjaan</label>
                <textarea name="uraian" rows="4" 
                          class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium text-slate-700 leading-relaxed" required>{{ old('uraian', $laporan->uraian) }}</textarea>
            </div>

            {{-- DOKUMENTASI FOTO --}}
            <div class="pt-6 border-t border-slate-50">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Dokumentasi Foto</h3>
                        <p class="text-[10px] text-slate-400 font-bold italic mt-1">* Wajib melampirkan minimal 2 foto kegiatan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach (($laporan->foto ?? []) as $index => $foto)
                        <div class="relative group aspect-square rounded-[1.5rem] overflow-hidden border-2 border-slate-100 shadow-sm transition-all hover:shadow-md">
                            <img src="{{ asset('storage/'.$foto) }}" class="w-full h-full object-cover">
                            
                            {{-- Overlay Controls --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                @if ($index < 2)
                                    <button type="button" onclick="gantiFoto({{ $laporan->id }}, {{ $index }})" 
                                            class="p-2 bg-white text-blue-600 rounded-xl shadow-lg transform active:scale-90 transition-all hover:bg-blue-600 hover:text-white" title="Ubah Foto">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4-4m4 4V4"/></svg>
                                    </button>
                                @else
                                    <button type="button" onclick="hapusFoto({{ $laporan->id }}, {{ $index }})" 
                                            class="p-2 bg-white text-rose-600 rounded-xl shadow-lg transform active:scale-90 transition-all hover:bg-rose-600 hover:text-white" title="Hapus Foto">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Add Button --}}
                    <button type="button" onclick="tambahFoto({{ $laporan->id }})" 
                            class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-[1.5rem] aspect-square hover:bg-blue-50 hover:border-blue-400 transition-all group">
                        <div class="p-3 bg-slate-50 text-slate-400 rounded-xl group-hover:bg-blue-100 group-hover:text-blue-600 transition-all mb-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-blue-600">Tambah</span>
                    </button>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="pt-10 flex flex-col md:flex-row items-center justify-end gap-5 border-t border-slate-50">
                <a href="{{ route('laporan_kegiatan.index') }}" 
                   class="w-full md:w-auto px-8 py-4 text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-[0.2em] transition-all text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-100 transform active:scale-95 transition-all text-sm uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal / File Inputs Tersembunyi --}}
<input type="file" id="fileGanti" hidden accept="image/*">
<input type="file" id="fileTambah" hidden accept="image/*">

<script>
let laporanId = null;
let fotoIndex = null;

function gantiFoto(id, index) {
    laporanId = id;
    fotoIndex = index;
    document.getElementById('fileGanti').click();
}

function tambahFoto(id) {
    laporanId = id;
    document.getElementById('fileTambah').click();
}

function hapusFoto(id, index) {
    if (!confirm('Yakin ingin menghapus foto dokumentasi ini?')) return;

    fetch(`/laporan_kegiatan/${id}/foto/${index}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            showToast('Foto berhasil dihapus');
            setTimeout(() => location.reload(), 800);
        } else {
            alert('Gagal menghapus foto.');
        }
    });
}

function showToast(message) {
    const msg = document.createElement('div');
    msg.innerText = message;
    msg.className = 'fixed top-10 right-10 bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-xl z-50 animate-bounce';
    document.body.appendChild(msg);
}

document.addEventListener('DOMContentLoaded', function () {
    const MAX_SIZE = 2 * 1024 * 1024; // 2MB
    const fileGanti = document.getElementById('fileGanti');
    const fileTambah = document.getElementById('fileTambah');

    function handleUpload(fileInput, url) {
        if (!fileInput.files.length) return;
        const file = fileInput.files[0];

        if (file.size > MAX_SIZE) {
            alert('Ukuran file terlalu besar (Maks 2MB)');
            fileInput.value = '';
            return;
        }

        let fd = new FormData();
        fd.append('foto', file);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: fd
        }).then(response => {
            if (response.ok) {
                showToast('Dokumentasi diperbarui');
                setTimeout(() => location.reload(), 800);
            } else {
                alert('Upload gagal');
            }
        });
    }

    fileGanti.addEventListener('change', () => handleUpload(fileGanti, `/laporan_kegiatan/${laporanId}/foto/${fotoIndex}/replace`));
    fileTambah.addEventListener('change', () => handleUpload(fileTambah, `/laporan_kegiatan/${laporanId}/foto/tambah`));
});
</script>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        opacity: 0.4;
        cursor: pointer;
    }
</style>
@endsection
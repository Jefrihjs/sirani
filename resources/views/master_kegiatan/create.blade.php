@extends('layouts.dashboard')

@section('title', 'Tambah Master Kegiatan')

@section('content')
{{-- Memastikan Tailwind Aktif --}}


<div class="p-6 md:p-12 max-w-3xl mx-auto">
    
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-indigo-600 rounded-2xl text-white shadow-xl shadow-indigo-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Master Kegiatan</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Tambahkan kategori jenis kegiatan baru</p>
            </div>
        </div>

        <a href="{{ route('master-kegiatan.index') }}" class="group flex items-center text-sm font-bold text-gray-400 hover:text-indigo-600 transition-all">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <form method="POST" action="{{ route('master-kegiatan.store') }}" class="p-8 md:p-12 space-y-8">
            @csrf

            {{-- Input Nama Kegiatan --}}
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700 ml-1 uppercase tracking-wider text-[11px]">Nama Kegiatan / Kategori</label>
                <input type="text"
                       name="nama_kegiatan"
                       class="w-full px-5 py-4 rounded-2xl border border-gray-200 bg-gray-50/50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-gray-700 placeholder-gray-400 font-medium"
                       placeholder="Contoh: Entry Data, Verifikasi Dokumen..."
                       required>
            </div>

            {{-- Admin Only Option --}}
            @if(auth()->user()->isAdmin())
            <div class="p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_global" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </div>
                    <div class="ml-4">
                        <span class="block text-sm font-bold text-indigo-900 group-hover:text-indigo-700 transition-colors">Jadikan Kegiatan Global</span>
                        <span class="block text-[11px] text-indigo-500 font-medium">Kegiatan ini akan muncul secara otomatis di semua akun User.</span>
                    </div>
                </label>
            </div>
            @endif

            {{-- ACTIONS --}}
            <div class="pt-8 flex flex-col md:flex-row items-center justify-end gap-5 border-t border-gray-50">
                <a href="{{ route('master-kegiatan.index') }}"
                   class="w-full md:w-auto px-8 py-4 text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-[0.2em] transition-all text-center">
                    Batal
                </a>
                
                <button type="submit" 
                        class="w-full md:w-auto px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 transform active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                    Simpan Kegiatan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
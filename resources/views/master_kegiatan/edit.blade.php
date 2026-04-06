@extends('layouts.dashboard')

@section('title', 'Edit Master Kegiatan')

@section('content')
{{-- Memastikan Tailwind Aktif --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-6 md:p-12 max-w-3xl mx-auto">
    
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-indigo-600 rounded-2xl text-white shadow-xl shadow-indigo-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Edit Master Kegiatan</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Perbarui informasi kategori kegiatan Anda</p>
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
        <form method="POST" action="{{ route('master-kegiatan.update', $row->id) }}" class="p-8 md:p-12 space-y-8">
            @csrf
            @method('PUT')

            {{-- Input Nama Kegiatan --}}
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700 ml-1 uppercase tracking-wider text-[11px]">Nama Kegiatan / Kategori</label>
                <input type="text"
                       name="nama_kegiatan"
                       value="{{ old('nama_kegiatan', $row->nama_kegiatan) }}"
                       class="w-full px-5 py-4 rounded-2xl border border-gray-200 bg-gray-50/50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-gray-700 font-medium"
                       required>
            </div>

            {{-- Status --}}
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700 ml-1 uppercase tracking-wider text-[11px]">Status Aktif</label>
                <div class="relative">
                    <select name="aktif" class="w-full px-5 py-4 rounded-2xl border border-gray-200 bg-gray-50/50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-gray-700 font-medium appearance-none cursor-pointer">
                        <option value="1" {{ $row->aktif ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$row->aktif ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    {{-- Icon Panah Kustom --}}
                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="pt-8 flex flex-col md:flex-row items-center justify-end gap-5 border-t border-gray-50">
                <a href="{{ route('master-kegiatan.index') }}"
                   class="w-full md:w-auto px-8 py-4 text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-[0.2em] transition-all text-center">
                    Batal
                </a>
                
                <button type="submit" 
                        class="w-full md:w-auto px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 transform active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
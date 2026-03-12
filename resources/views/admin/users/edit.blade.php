@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
{{-- Memastikan Tailwind Aktif --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-6 md:p-12 max-w-4xl mx-auto space-y-8">
    
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-slate-800 rounded-2xl text-white shadow-xl shadow-slate-200">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Edit Profil User</h1>
                <p class="text-sm text-slate-500 font-medium mt-1">Perbarui akses dan informasi akun pengguna</p>
            </div>
        </div>

        <a href="{{ route('admin.users.index') }}" class="group flex items-center text-sm font-bold text-gray-400 hover:text-slate-800 transition-all">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ALERT VALIDASI --}}
    @if ($errors->any())
    <div class="p-5 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl shadow-sm animate-pulse">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-xs font-black text-rose-800 uppercase tracking-widest">Kesalahan Input</h3>
                <ul class="mt-1 text-xs text-rose-700 font-medium list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- CARD FORM --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8 md:p-12 space-y-10">
            @csrf
            @method('PUT')

            {{-- SECTION 1: INFORMASI DASAR --}}
            <div class="space-y-6">
                <div class="flex items-center space-x-2 pb-2 border-b border-slate-50">
                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Identitas</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">NIP Pegawai</label>
                        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" 
                            class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                </div>
            </div>

            {{-- SECTION 2: AKSES SISTEM --}}
            <div class="space-y-6">
                <div class="flex items-center space-x-2 pb-2 border-b border-slate-50">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Konfigurasi Akses</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Hak Akses (Role)</label>
                        <div class="relative">
                            <select name="role" class="w-full appearance-none px-5 py-4 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 cursor-pointer">
                                <option value="pegawai" {{ $user->role == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Status Keaktifan</label>
                        <div class="relative">
                            <select name="is_active" class="w-full appearance-none px-5 py-4 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 cursor-pointer">
                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: KEAMANAN --}}
            <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Ganti Password (Opsional)</label>
                    <span class="px-2 py-0.5 bg-white text-[9px] font-bold text-slate-400 rounded-md border border-slate-200 uppercase tracking-tighter">Security Area</span>
                </div>
                <input type="password" name="password" placeholder="Masukkan password baru jika ingin mengganti..." 
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all font-medium">
                <div class="flex items-center text-[10px] text-slate-400 font-bold italic ml-1">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    Biarkan kosong jika tidak ingin mengubah password lama.
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="pt-8 flex flex-col md:flex-row items-center justify-end gap-5 border-t border-slate-50">
                <button type="reset" class="w-full md:w-auto px-8 py-4 text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-[0.2em] transition-all text-center text-center">
                    Reset Form
                </button>
                
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-slate-900 hover:bg-black text-white font-bold rounded-2xl shadow-lg shadow-slate-100 transform active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
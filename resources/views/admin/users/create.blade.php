@extends('layouts.dashboard')

@section('title', 'Tambah User')

@section('content')
{{-- Memastikan Tailwind Aktif --}}


<div class="p-6 md:p-12 max-w-3xl mx-auto">
    
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-slate-800 rounded-2xl text-white shadow-xl shadow-slate-200">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah User</h1>
                <p class="text-sm text-slate-500 font-medium mt-1">Daftarkan akun pegawai baru ke sistem</p>
            </div>
        </div>

        <a href="{{ route('admin.users.index') }}" class="group flex items-center text-sm font-bold text-gray-400 hover:text-slate-800 transition-all">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 md:p-12 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nama Lengkap --}}
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama tanpa gelar..." 
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-slate-500/10 focus:border-slate-500 outline-none transition-all font-medium" required>
                </div>

                {{-- NIP --}}
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">NIP Pegawai</label>
                    <input type="text" name="nip" placeholder="19xxxxxxxxxxxxxx" 
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-slate-500/10 focus:border-slate-500 outline-none transition-all font-medium" required>
                </div>
            </div>

            {{-- Email --}}
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                <input type="email" name="email" placeholder="contoh@domain.com" 
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-slate-500/10 focus:border-slate-500 outline-none transition-all font-medium" required>
            </div>

            {{-- Password --}}
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password Akun</label>
                <input type="password" name="password" placeholder="••••••••" 
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-slate-500/10 focus:border-slate-500 outline-none transition-all font-medium" required>
                <p class="text-[10px] text-slate-400 font-bold italic ml-1">Gunakan minimal 8 karakter kombinasi.</p>
            </div>

            {{-- Role --}}
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Hak Akses (Role)</label>
                <div class="relative">
                    <select name="role" class="w-full appearance-none px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50/50 focus:ring-4 focus:ring-slate-500/10 focus:border-slate-500 outline-none transition-all font-bold text-slate-700 cursor-pointer">
                        <option value="pegawai">Pegawai</option>
                        <option value="admin">Administrator</option>
                    </select>
                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="pt-8 flex flex-col md:flex-row items-center justify-end gap-5 border-t border-slate-50">
                <button type="reset" class="w-full md:w-auto px-8 py-4 text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-[0.2em] transition-all text-center">
                    Reset
                </button>
                
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-slate-900 hover:bg-black text-white font-bold rounded-2xl shadow-lg shadow-slate-100 transform active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
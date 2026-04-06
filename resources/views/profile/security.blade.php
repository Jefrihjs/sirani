@extends('layouts.dashboard')

@section('title', 'Keamanan Akun')

@section('content')
{{-- Memanggil Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-4 md:p-10 max-w-4xl mx-auto space-y-8">
    
    {{-- HEADER --}}
    <div class="flex items-center space-x-4 mb-2">
        <div class="p-3 bg-slate-800 rounded-2xl text-white shadow-lg shadow-slate-200">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Keamanan Akun</h1>
            <p class="text-sm text-slate-500 font-medium leading-tight">Kelola kata sandi untuk melindungi akun ASN Anda</p>
        </div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12">
            
            {{-- ALERT VALIDASI (Jika ada error) --}}
            @if ($errors->any())
                <div class="mb-8 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl text-rose-700 text-sm font-bold uppercase tracking-wider">
                    Periksa kembali inputan Anda.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Password Lama --}}
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password Saat Ini</label>
                        <div class="relative group">
                            <input type="password" name="current_password" id="current_password"
                                   class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium pr-12 bg-slate-50/30" 
                                   placeholder="••••••••" required>
                            <button type="button" onclick="togglePass('current_password', this)" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100/50">
                            <p class="text-[11px] text-blue-600 font-bold uppercase tracking-widest mb-1">Tips Keamanan</p>
                            <p class="text-xs text-blue-500 leading-relaxed">Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk password yang lebih kuat.</p>
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password Baru</label>
                        <div class="relative group">
                            <input type="password" name="password" id="password"
                                   class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium pr-12 bg-slate-50/30" 
                                   placeholder="••••••••" required>
                            <button type="button" onclick="togglePass('password', this)" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Konfirmasi Password Baru</label>
                        <div class="relative group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-medium pr-12 bg-slate-50/30" 
                                   placeholder="••••••••" required>
                            <button type="button" onclick="togglePass('password_confirmation', this)" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- ACTION BUTTON --}}
                <div class="pt-8 border-t border-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-[11px] text-slate-400 font-medium">Terakhir diganti: <span class="text-slate-600">3 bulan yang lalu</span></p>
                    <button type="submit" 
                            class="w-full md:w-auto px-10 py-4 bg-slate-900 hover:bg-blue-600 text-white font-bold rounded-2xl shadow-lg shadow-slate-200 transform active:scale-95 transition-all text-xs uppercase tracking-[0.2em]">
                        Update Kata Sandi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('svg');

    if (input.type === "password") {
        input.type = "text";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
    } else {
        input.type = "password";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
}
</script>
@endsection
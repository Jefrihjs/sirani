<x-guest-layout>
{{-- Memanggil Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-slate-950 relative overflow-hidden font-sans">
    
    {{-- Dekorasi Cahaya Latar (2026 Vibes) --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-[450px] px-6 relative z-10">
        
        {{-- CARD LOGIN --}}
        <div class="bg-white/5 backdrop-blur-2xl rounded-[3rem] border border-white/10 p-10 md:p-14 shadow-2xl">
            
            {{-- HEADER: LOGO & JUDUL --}}
            <div class="text-center space-y-4 mb-12">
                <div class="inline-block p-4 bg-white rounded-[2rem] shadow-xl shadow-blue-500/10 transform -rotate-6 transition-transform hover:rotate-0 duration-500 relative group">
                    {{-- Efek cahaya lembut di belakang logo --}}
                    <div class="absolute inset-0 bg-blue-500/20 rounded-[2rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    {{-- Kita HAPUS 'invert brightness-0' agar warna perisai biru-hijaunya muncul --}}
                    <img src="{{ asset('img/siceria-logo.png') }}" 
                        class="w-12 h-12 object-contain relative z-10" 
                        alt="Logo SiCERIA">
                </div>
                
                <div class="space-y-1">
                    <h1 class="text-4xl font-black text-white tracking-tighter italic">Si<span class="text-blue-500">CERIA</span></h1>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em]">Sistem Capaian Elektronik & Reporting Informasi ASN</p>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-8">
                @csrf

                {{-- INPUT NIP --}}
                <div class="space-y-2 group">
                    <label for="nip" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 group-focus-within:text-blue-500 transition-colors">NIP Pegawai</label>
                    <div class="relative">
                        <input id="nip" type="text" name="nip" value="{{ old('nip') }}" required autofocus
                               class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white font-bold placeholder-slate-600 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                               placeholder="19xxxxxxxxxxxxxx">
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none opacity-20 group-focus-within:opacity-100 transition-opacity">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                    @error('nip') <p class="text-[10px] font-bold text-rose-500 uppercase tracking-tighter ml-2 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- INPUT PASSWORD --}}
                <div class="space-y-2 group">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-500 transition-colors">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-2xl text-white font-bold placeholder-slate-600 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-5 flex items-center text-slate-500 hover:text-blue-500 transition-colors">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="text-[10px] font-bold text-rose-500 uppercase tracking-tighter ml-2 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- REMEMBER & FORGOT --}}
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-600 focus:ring-blue-500/20">
                        <span class="ml-2 text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition-colors">Ingat Saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-blue-500 uppercase tracking-widest hover:text-blue-400 transition-colors underline decoration-2 underline-offset-4">Lupa Sandi?</a>
                </div>

                {{-- BUTTON LOGIN --}}
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full py-5 bg-blue-600 hover:bg-white text-white hover:text-blue-600 font-black rounded-2xl shadow-2xl shadow-blue-600/20 transition-all transform active:scale-95 uppercase tracking-[0.3em] text-xs">
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-12 text-center">
                <p class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.4em]">SiCERIA Belitung Timur &copy; 2026</p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
</x-guest-layout>
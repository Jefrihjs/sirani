{{-- Script Alpine.js agar Dropdown & Toggle PASTI jalan --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<aside id="sidebar" 
    {{-- Logic Toggle & Dropdown digabung di sini --}}
    x-data="{ 
        isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        rekapOpen: {{ request()->routeIs('rekap.*') ? 'true' : 'false' }}, 
        settingOpen: {{ request()->routeIs('profil.*', 'profile.security') ? 'true' : 'false' }},
        toggle() {
            this.isCollapsed = !this.isCollapsed;
            localStorage.setItem('sidebarCollapsed', this.isCollapsed);
            window.dispatchEvent(new CustomEvent('sidebar-toggled', { detail: this.isCollapsed }));
        }
    }"
    {{-- Class Dinamis untuk lebar sidebar --}}
    :class="isCollapsed ? 'w-20' : 'w-72'"
    class="fixed left-0 top-0 h-screen bg-slate-900 text-white flex flex-col z-[100] border-r border-white/5 shadow-2xl transition-all duration-500 overflow-hidden group/sidebar">
    
    {{-- Cahaya Dekorasi --}}
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="flex-1 overflow-y-auto custom-scrollbar relative z-10 overflow-x-hidden">

        {{-- HEADER: LOGO & TOMBOL TOGGLE --}}
        <div class="p-6 mb-4 border-b border-white/5 bg-slate-950/30">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-white rounded-2xl shadow-xl shrink-0">
                        <img src="{{ asset('img/siceria-logo.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                    </div>
                    {{-- Teks Brand Hilang kalau Collapsed --}}
                    <h1 x-show="!isCollapsed" x-transition.opacity class="text-4xl font-black text-white tracking-tighter italic">
                        Si<span class="text-blue-500">CERIA</span>
                    </h1>
                </div>
            </div>

            {{-- TOMBOL PANAH TOGGLE --}}
            <button @click="toggle()" class="w-full flex items-center justify-center p-3 bg-white/5 hover:bg-blue-600 rounded-xl transition-all text-white shadow-inner">
                <svg :class="isCollapsed ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>

        {{-- MENU UTAMA (ISI TETAP SAMA) --}}
        <nav class="px-3 space-y-2 mt-4">
    
            {{-- 1. DASHBOARD --}}
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 px-4 py-4 rounded-2xl transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="w-6 h-6 shrink-0">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </span>
                <span x-show="!isCollapsed" class="font-black text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Dashboard</span>
            </a>

            {{-- 2. LAPORAN KERJA (Menu yang tadi hilang) --}}
            <a href="{{ route('laporan_kegiatan.index') }}" class="flex items-center space-x-4 px-4 py-4 rounded-2xl transition-all {{ request()->routeIs('laporan_kegiatan.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="w-6 h-6 shrink-0">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </span>
                <span x-show="!isCollapsed" class="font-black text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Laporan Kerja</span>
            </a>

            {{-- 3. REKAP DROPDOWN (MELAYANG) --}}
            <div class="relative group/menu" x-data="{ open: false }">
                <button @click="isCollapsed ? open = !open : rekapOpen = !rekapOpen" 
                        type="button" 
                        class="w-full flex items-center justify-between px-4 py-4 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                    <div class="flex items-center space-x-4">
                        <span class="w-6 h-6 shrink-0"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg></span>
                        <span x-show="!isCollapsed" class="font-black text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Rekapitulasi</span>
                    </div>
                    <svg x-show="!isCollapsed" :class="rekapOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                </button>

                {{-- Dropdown Melayang Rekap --}}
                <div x-show="isCollapsed && open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    class="fixed left-[75px] bg-slate-800 border border-white/10 rounded-2xl shadow-2xl p-2 min-w-[180px] z-[9999]" style="margin-top: -50px;">
                    <a href="{{ route('rekap.triwulan') }}" class="block p-3 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-blue-400 hover:bg-white/5 rounded-xl transition-all">Triwulan</a>
                    <a href="{{ route('rekap.tahunan') }}" class="block p-3 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-blue-400 hover:bg-white/5 rounded-xl transition-all">Tahunan</a>
                </div>

                {{-- Dropdown Normal Rekap --}}
                <div x-show="rekapOpen && !isCollapsed" x-transition class="pl-12 space-y-2 mt-2 border-l border-white/5 ml-6">
                    <a href="{{ route('rekap.triwulan') }}" class="block text-[10px] font-black uppercase tracking-widest hover:text-blue-400 transition-colors">Triwulan</a>
                    <a href="{{ route('rekap.tahunan') }}" class="block text-[10px] font-black uppercase tracking-widest hover:text-blue-400 transition-colors">Tahunan</a>
                </div>
            </div>

            {{-- 4. MASTER DATA (Menu yang tadi hilang) --}}
            <a href="{{ route('master-kegiatan.index') }}" class="flex items-center space-x-4 px-4 py-4 rounded-2xl transition-all {{ request()->routeIs('master-kegiatan.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="w-6 h-6 shrink-0">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2"/></svg>
                </span>
                <span x-show="!isCollapsed" class="font-black text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Master Data</span>
            </a>

            {{-- 5. PENGATURAN DROPDOWN (MELAYANG) --}}
            <div class="relative group/menu" x-data="{ open: false }">
                <button @click="isCollapsed ? open = !open : settingOpen = !settingOpen" 
                        type="button" 
                        class="w-full flex items-center justify-between px-4 py-4 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                    <div class="flex items-center space-x-4">
                        <span class="w-6 h-6 shrink-0"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg></span>
                        <span x-show="!isCollapsed" class="font-black text-[11px] uppercase tracking-[0.2em] whitespace-nowrap">Pengaturan</span>
                    </div>
                    <svg x-show="!isCollapsed" :class="settingOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                </button>

                {{-- Dropdown Melayang Pengaturan --}}
                <div x-show="isCollapsed && open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    class="fixed left-[75px] bg-slate-800 border border-white/10 rounded-2xl shadow-2xl p-2 min-w-[180px] z-[9999]" style="margin-top: -50px;">
                    <a href="{{ route('profil.asn') }}" class="block p-3 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-blue-400 hover:bg-white/5 rounded-xl transition-all">Profil ASN</a>
                    <a href="{{ route('profile.security') }}" class="block p-3 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-blue-400 hover:bg-white/5 rounded-xl transition-all">Keamanan</a>
                </div>

                {{-- Dropdown Normal Pengaturan --}}
                <div x-show="settingOpen && !isCollapsed" x-transition class="pl-12 space-y-2 mt-2 border-l border-white/5 ml-6">
                    <a href="{{ route('profil.asn') }}" class="block text-[10px] font-black uppercase tracking-widest hover:text-blue-400">Profil ASN</a>
                    <a href="{{ route('profile.security') }}" class="block text-[10px] font-black uppercase tracking-widest hover:text-blue-400">Keamanan</a>
                </div>
            </div>
        </nav>
    </div>

    {{-- BAGIAN BAWAH: PROFIL --}}
    <div class="p-4 border-t border-white/5 bg-slate-950/50 backdrop-blur-md">
        <a href="{{ route('profil.asn.edit') }}" class="flex items-center p-2 rounded-2xl bg-white/5 hover:bg-white/10 transition-all mb-4">
            <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                 class="w-10 h-10 rounded-xl object-cover shrink-0 shadow-lg border border-white/10">
            <div x-show="!isCollapsed" class="ml-3 min-w-0">
                <p class="text-[11px] font-black text-white truncate uppercase italic">{{ auth()->user()->name }}</p>
                <p class="text-[9px] font-bold text-slate-500 truncate tracking-widest">{{ auth()->user()->nip }}</p>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="px-2">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center space-x-2 py-3 bg-rose-500/10 hover:bg-rose-600 text-rose-500 hover:text-white rounded-xl transition-all font-black text-[9px] uppercase tracking-[0.2em]">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span x-show="!isCollapsed" class="whitespace-nowrap">Logout Sistem</span>
            </button>
        </form>
    </div>
</aside>
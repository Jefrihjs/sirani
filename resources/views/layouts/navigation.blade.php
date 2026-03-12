<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="scrolled ? 'bg-white/80 backdrop-blur-md shadow-lg border-slate-200' : 'bg-transparent border-transparent'"
     class="sticky top-0 z-50 transition-all duration-500 border-b">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center space-x-3">
                        <div class="p-2 bg-blue-600 rounded-xl group-hover:rotate-12 transition-transform duration-300 shadow-lg shadow-blue-200">
                             <x-application-logo class="h-6 w-auto fill-current text-white" />
                        </div>
                        <span class="text-xl font-black text-slate-800 tracking-tighter uppercase">Si<span class="text-blue-600">Ceria</span></span>
                    </a>
                </div>

                <div class="hidden space-x-1 ml-12 lg:flex bg-slate-100/50 p-1.5 rounded-2xl border border-slate-200/50">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('laporan_kegiatan.index')" :active="request()->routeIs('laporan_kegiatan.*')"
                        class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                        {{ __('Laporan') }}
                    </x-nav-link>

                    <div class="relative" x-data="{ rekapOpen: false }">
                        <button @click="rekapOpen = !rekapOpen" 
                                :class="request()->routeIs('laporan_kegiatan.rekap_*') ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500'"
                                class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white transition-all">
                            Rekap
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="rekapOpen" @click.away="rekapOpen = false" 
                             class="absolute mt-2 w-48 bg-white rounded-2xl shadow-2xl border border-slate-100 p-2 z-50">
                            <a href="{{ route('laporan_kegiatan.rekap_triwulan') }}" class="block px-4 py-3 rounded-xl text-[10px] font-black uppercase text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">Triwulan</a>
                            <a href="{{ route('laporan_kegiatan.rekap_tahunan') }}" class="block px-4 py-3 rounded-xl text-[10px] font-black uppercase text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">Tahunan</a>
                        </div>
                    </div>

                    <x-nav-link :href="route('master-kegiatan.index')" :active="request()->routeIs('master-kegiatan.*')"
                        class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                        {{ __('Master') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <div class="flex items-center bg-white border border-slate-100 rounded-2xl p-1 shadow-sm">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center px-3 py-2 space-x-3 hover:bg-slate-50 rounded-xl transition-all">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xs border border-blue-200">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left leading-none">
                                    <div class="text-[10px] font-black text-slate-800 uppercase tracking-tight">{{ Auth::user()->name }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 mt-0.5 uppercase tracking-tighter">ASN Belitung Timur</div>
                                </div>
                                <svg class="fill-current h-4 w-4 text-slate-300" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-2">
                                <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-bold text-xs uppercase tracking-widest text-slate-600 hover:bg-blue-50">
                                    Profil Saya
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="rounded-xl font-bold text-xs uppercase tracking-widest text-rose-600 hover:bg-rose-50"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Keluar') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-3 rounded-2xl bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition-all duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="sm:hidden bg-white border-t border-slate-100 p-4 space-y-2 shadow-2xl">
        
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl font-black uppercase text-[10px] tracking-[0.2em]">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('laporan_kegiatan.index')" :active="request()->routeIs('laporan_kegiatan.*')" class="rounded-xl font-black uppercase text-[10px] tracking-[0.2em]">Input Laporan</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('laporan_kegiatan.rekap_triwulan')" :active="request()->routeIs('laporan_kegiatan.rekap_triwulan')" class="rounded-xl font-black uppercase text-[10px] tracking-[0.2em]">Rekap Triwulan</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('laporan_kegiatan.rekap_tahunan')" :active="request()->routeIs('laporan_kegiatan.rekap_tahunan')" class="rounded-xl font-black uppercase text-[10px] tracking-[0.2em]">Rekap Tahunan</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('master-kegiatan.index')" :active="request()->routeIs('master-kegiatan.*')" class="rounded-xl font-black uppercase text-[10px] tracking-[0.2em]">Master Kegiatan</x-responsive-nav-link>
    </div>
</nav>
@extends('layouts.dashboard')

@section('title', 'Manajemen User')

@section('content')
{{-- Memastikan Tailwind Aktif --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-6 md:p-10 max-w-7xl mx-auto space-y-8">
    
    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-slate-800 rounded-2xl text-white shadow-xl shadow-slate-200">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen User</h1>
                <p class="text-slate-500 font-medium mt-1 text-sm italic">Otoritas kendali akses sistem SIRANI</p>
            </div>
        </div>

        <a href="{{ route('admin.users.create') }}" 
           class="inline-flex items-center px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-100 transition-all transform active:scale-95 text-xs uppercase tracking-widest group">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah User Baru
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-center">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-left">Pengguna</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Email & Kontak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-32">Role</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-32">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right w-40">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0 bg-slate-100 text-slate-500 rounded-2xl flex items-center justify-center font-black text-lg border-2 border-white shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-black text-slate-700 leading-tight">{{ $user->name }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mt-0.5">UID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="text-sm font-medium text-slate-500">{{ $user->email }}</span>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest text-purple-600 bg-purple-50 border border-purple-100 rounded-lg">Administrator</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 border border-blue-100 rounded-lg">Pegawai</span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="status-form-{{ $user->id }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="is_active" value="0">
                                    <label class="relative inline-flex items-center cursor-pointer group-hover:scale-110 transition-transform">
                                        <input type="checkbox" name="is_active" value="1" 
                                               onchange="document.getElementById('status-form-{{ $user->id }}').submit()"
                                               class="sr-only peer" {{ $user->is_active ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                    </label>
                                </form>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase italic">Sesi Aktif</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($user->id !== auth()->id())
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="p-2.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-slate-200 text-xs">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="bg-slate-50/50 px-8 py-6 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
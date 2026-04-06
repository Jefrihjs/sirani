@extends('layouts.dashboard')

@section('title', 'Perbarui Profil ASN')

@section('content')
{{-- Memastikan Tailwind Aktif --}}


<div class="p-6 md:p-12 max-w-5xl mx-auto space-y-10 text-slate-800">
    
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-slate-900 rounded-3xl text-white shadow-2xl shadow-slate-200 transform -rotate-3">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black tracking-tight uppercase italic">Pengaturan Profil</h1>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.3em] mt-1">Sinkronisasi Data Kepegawaian ASN</p>
            </div>
        </div>

        <a href="{{ route('profil.asn') }}" class="group flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-all">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Profil
        </a>
    </div>

    {{-- CARD UTAMA --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden relative">
        {{-- Dekorasi Aksen --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full -mr-16 -mt-16 opacity-50"></div>

        <form method="POST" action="{{ route('profil.asn.update') }}" enctype="multipart/form-data" class="p-8 md:p-16 space-y-12 relative z-10">
            @csrf

            {{-- SECTION 1: AVATAR MANAGEMENT --}}
            <div class="flex flex-col md:flex-row items-center gap-10 pb-12 border-b border-slate-50">
                <div class="relative group">
                    @php
                        $photoUrl = $user->photo && file_exists(storage_path('app/public/'.$user->photo))
                            ? asset('storage/' . $user->photo) . '?v=' . time()
                            : 'https://ui-avatars.com/api/?size=200&background=1e293b&color=fff&name=' . urlencode($user->name);
                    @endphp
                    <div class="p-2 bg-slate-50 rounded-[2.5rem] border border-slate-100 shadow-inner">
                        <img id="preview-image" src="{{ $photoUrl }}" 
                             class="w-36 h-36 md:w-44 md:h-44 rounded-[2rem] object-cover shadow-2xl transition-all duration-500 group-hover:scale-[1.02]">
                    </div>
                    <label for="photo-input" class="absolute bottom-4 right-4 p-3 bg-blue-600 text-white rounded-2xl shadow-xl shadow-blue-200 cursor-pointer hover:bg-slate-900 transition-colors transform hover:rotate-12">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </label>
                    <input type="file" name="photo" id="photo-input" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                </div>
                
                <div class="text-center md:text-left space-y-3">
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Otoritas Citra Diri</h3>
                    <p class="text-slate-800 font-black text-xl tracking-tighter italic uppercase underline decoration-blue-500 decoration-4 underline-offset-4">Foto Profil Resmi</p>
                    <p class="text-[10px] text-slate-400 font-bold max-w-xs leading-relaxed uppercase opacity-70">Gunakan foto formal dengan pencahayaan cukup. Maksimal file berukuran 2MB.</p>
                </div>
            </div>

            {{-- SECTION 2: FORM DATA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Nama Lengkap (Terkunci)</label>
                    <input type="text" value="{{ $user->name }}" class="w-full px-6 py-5 rounded-[1.5rem] border border-slate-100 bg-slate-50 text-slate-400 font-bold uppercase italic cursor-not-allowed" disabled>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Nomor Induk Pegawai</label>
                    <input type="text" value="{{ $user->nip }}" class="w-full px-6 py-5 rounded-[1.5rem] border border-slate-100 bg-slate-50 text-slate-400 font-bold tracking-widest cursor-not-allowed" disabled>
                </div>

                <div class="space-y-3 md:col-span-2 group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1 group-hover:text-blue-600 transition-colors">Jabatan Definitif / Tugas Tambahan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $profile->jabatan ?? '') }}" 
                           class="w-full px-6 py-5 rounded-[1.5rem] border border-slate-200 bg-white focus:ring-8 focus:ring-blue-500/5 focus:border-blue-600 outline-none transition-all font-black text-slate-700 uppercase italic placeholder-slate-200 shadow-sm" placeholder="Contoh: PRANATA KOMPUTER MUDA" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Kategori Jabatan</label>
                    <div class="relative">
                        <select name="jenis_jabatan" class="w-full appearance-none px-6 py-5 rounded-[1.5rem] border border-slate-200 bg-white focus:ring-8 focus:ring-blue-500/5 focus:border-blue-600 outline-none transition-all font-black text-slate-700 uppercase cursor-pointer shadow-sm">
                            @php $currentJenis = old('jenis_jabatan', $profile->jenis_jabatan); @endphp
                            <option value="Fungsional" {{ $currentJenis === 'Fungsional' ? 'selected' : '' }}>Fungsional</option>
                            <option value="Struktural" {{ $currentJenis === 'Struktural' ? 'selected' : '' }}>Struktural</option>
                            <option value="Pelaksana" {{ $currentJenis === 'Pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                        </select>
                        <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-blue-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Golongan / Ruang</label>
                    <input type="text" name="golongan_ruang" value="{{ old('golongan_ruang', $profile->golongan_ruang ?? '') }}" 
                           class="w-full px-6 py-5 rounded-[1.5rem] border border-slate-200 bg-white focus:ring-8 focus:ring-blue-500/5 focus:border-blue-600 outline-none transition-all font-black text-slate-700 uppercase shadow-sm" placeholder="III/b" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Unit Kerja Utama</label>
                    <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $profile->unit_kerja ?? '') }}" 
                           class="w-full px-6 py-5 rounded-[1.5rem] border border-slate-200 bg-white focus:ring-8 focus:ring-blue-500/5 focus:border-blue-600 outline-none transition-all font-black text-slate-700 uppercase italic shadow-sm" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-1">Pimpinan / Atasan Langsung</label>
                    <div class="relative">
                        <select name="atasan_id" class="w-full appearance-none px-6 py-5 rounded-[1.5rem] border border-slate-200 bg-white focus:ring-8 focus:ring-blue-500/5 focus:border-blue-600 outline-none transition-all font-black text-slate-700 uppercase cursor-pointer shadow-sm">
                            <option value="">- Cari Pejabat Penilai -</option>
                            @foreach ($atasanList as $atasan)
                                <option value="{{ $atasan->id }}" {{ old('atasan_id', $profile->atasan_id) == $atasan->id ? 'selected' : '' }}>{{ $atasan->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-blue-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="pt-12 flex flex-col md:flex-row items-center justify-end gap-6 border-t border-slate-50">
                <button type="reset" class="w-full md:w-auto px-10 py-5 text-xs font-black text-slate-400 hover:text-slate-900 uppercase tracking-[0.3em] transition-all">Reset Data</button>
                <button type="submit" 
                        class="w-full md:w-auto px-16 py-5 bg-slate-900 hover:bg-blue-600 text-white font-black rounded-2xl shadow-2xl shadow-slate-200 transform active:scale-95 transition-all text-sm uppercase tracking-[0.3em]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
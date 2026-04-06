@extends('layouts.dashboard')

@section('title', 'Master Kegiatan')

@section('content')
{{-- Memastikan Tailwind Aktif via CDN --}}
<script src="https://cdn.tailwindcss.com"></script>
<div class="p-6 md:p-10 max-w-6xl mx-auto">

    {{-- ALERT NOTIFIKASI --}}
    @if (session('success'))
        <div class="mb-8 flex items-center p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-3xl shadow-sm animate-bounce-short">
            <div class="flex-shrink-0 text-emerald-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-4 text-xs font-black text-emerald-800 uppercase tracking-[0.2em]">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div class="flex items-center space-x-5">
            <div class="p-4 bg-indigo-600 rounded-[1.5rem] text-white shadow-2xl shadow-indigo-200">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Master Kegiatan</h1>
                <p class="text-slate-400 font-medium mt-1">Konfigurasi jenis aktivitas kerja harian ASN</p>
            </div>
        </div>

        <a href="{{ route('master-kegiatan.create') }}" 
           class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 transition-all transform active:scale-95 group text-xs uppercase tracking-widest">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Kegiatan
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-center">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] w-24">No</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-left">Nama Kegiatan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] w-40 text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-right w-48">Opsi Kendali</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($data as $i => $row)
                    <tr class="hover:bg-indigo-50/30 transition-all duration-300 group">
                        <td class="px-8 py-7 text-sm font-bold text-slate-400 text-center">{{ $i + 1 }}</td>
                        
                        <td class="px-6 py-7">
                            <div class="flex flex-col gap-2">
                                <span class="text-slate-700 font-black tracking-tight text-base leading-tight group-hover:text-indigo-600 transition-colors">{{ $row->nama_kegiatan }}</span>
                                <div class="flex items-center gap-2">
                                    @if($row->is_global)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-[0.1em] bg-indigo-100 text-indigo-600 border border-indigo-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-2.75-.163 1 1 0 00-.859 1.031l.211 2.459a1 1 0 00.993.914l6.752.136a1 1 0 00.993-.914l.211-2.459a1 1 0 00-.859-1.031 8.944 8.944 0 00-2.752.163V10.12l.69-.295a1.001 1.001 0 00.257-.357l2.154-.924 2.154.924a1.001 1.001 0 00.257.357l.69.295v4.102a8.969 8.969 0 00-2.75-.163 1 1 0 00-.859 1.031l.211 2.459a1 1 0 00.993.914l6.752.136a1 1 0 00.993-.914l.211-2.459a1 1 0 00-.859-1.031 8.944 8.944 0 00-2.752.163V10.12l1.69-.723a1 1 0 000-1.838l-7-3z"/></svg>
                                            Kategori Global
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-[0.1em] bg-slate-100 text-slate-500 border border-slate-200 italic">Personal</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-7 text-center">
                            @if($row->aktif)
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-slate-50 text-slate-400 border border-slate-100 uppercase tracking-widest">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-8 py-7 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                {{-- EDIT --}}
                                <a href="{{ route('master-kegiatan.edit', $row->id) }}" 
                                class="flex items-center justify-center w-10 h-10 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-2xl transition-all shadow-sm active:scale-90"
                                title="Edit Kegiatan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('master-kegiatan.destroy', $row->id) }}" method="POST" class="inline-flex m-0 p-0">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="konfirmasiHapus(this, event)" 
                                            class="flex items-center justify-center w-10 h-10 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-2xl transition-all shadow-sm active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-28 text-center bg-slate-50/20">
                            <div class="flex flex-col items-center">
                                <div class="p-8 bg-white rounded-full shadow-inner mb-6">
                                    <svg class="w-16 h-16 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Master Data Kosong</h3>
                                <p class="text-slate-400 text-xs mt-2 font-medium">Belum ada kategori kegiatan yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function konfirmasiHapus(button, event) {
        // 1. Hentikan aksi asli
        event.preventDefault();
        
        // 2. Cari form terdekat
        const form = button.closest('.form-hapus');
        
        console.log("Fungsi konfirmasiHapus terpanggil!"); // Cek di F12

        // 3. Jalankan SweetAlert
        Swal.fire({
            title: 'HAPUS DATA?',
            text: "Data akan dihapus permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'YA, HAPUS!',
            cancelButtonText: 'BATAL',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl px-6 py-3 font-bold',
                cancelButton: 'rounded-xl px-6 py-3 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Tombol Ya diklik, mengirim form...");
                form.submit();
            }
        });
    }
</script>
@endsection
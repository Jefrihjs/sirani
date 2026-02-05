<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('profil.asn') }}"
            class="block bg-white p-6 rounded shadow hover:shadow-md border">
                <div class="flex items-center gap-3">
                    <span class="text-orange-600 text-3xl">👤</span>
                    <div>
                        <h3 class="font-semibold text-lg">Profil ASN</h3>
                        <p class="text-sm text-gray-500">
                            Lihat & perbarui data profil ASN
                        </p>
                    </div>
                </div>
            </a>

        {{-- INPUT LAPORAN --}}
        <a href="{{ route('laporan_kegiatan.index') }}"
           class="block bg-white p-6 rounded shadow hover:shadow-md border">
            <div class="flex items-center gap-3">
                <span class="text-blue-600 text-3xl">➕</span>
                <div>
                    <h3 class="font-semibold text-lg">Input Laporan</h3>
                    <p class="text-sm text-gray-500">
                        Tambah & kelola laporan kegiatan
                    </p>
                </div>
            </div>
        </a>

        {{-- REKAP TRIWULAN --}}
        <a href="{{ route('laporan_kegiatan.rekap_triwulan') }}"
           class="block bg-white p-6 rounded shadow hover:shadow-md border">
            <div class="flex items-center gap-3">
                <span class="text-green-600 text-3xl">📄</span>
                <div>
                    <h3 class="font-semibold text-lg">Rekap Triwulan</h3>
                    <p class="text-sm text-gray-500">
                        Laporan kegiatan per triwulan
                    </p>
                </div>
            </div>
        </a>

        {{-- REKAP TAHUNAN --}}
        <a href="{{ route('laporan_kegiatan.rekap_tahunan') }}"
           class="block bg-white p-6 rounded shadow hover:shadow-md border">
            <div class="flex items-center gap-3">
                <span class="text-purple-600 text-3xl">📊</span>
                <div>
                    <h3 class="font-semibold text-lg">Rekap Tahunan</h3>
                    <p class="text-sm text-gray-500">
                        Rekap kegiatan satu tahun
                    </p>
                </div>
            </div>
        </a>

    </div>
</x-app-layout>

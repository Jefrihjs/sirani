<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AsnProfileController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\DashboardController;
use App\Exports\RekapTriwulanExport;
use App\Exports\RekapTahunanExport;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware(['auth'])->group(function () {

    // routes/web.php
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');  
    
    Route::get('/profil-asn', [AsnProfileController::class, 'show'])->name('profil.asn');
    Route::get('/profil-asn/edit', [AsnProfileController::class, 'edit'])->name('profil.asn.edit');
    Route::post('/profil-asn/update', [AsnProfileController::class, 'update'])->name('profil.asn.update');   
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile/photo', [ProfileController::class, 'photo'])
        ->name('profile.photo');
    
    Route::resource('master-kegiatan', MasterKegiatanController::class);
    Route::resource('laporan_kegiatan', LaporanKegiatanController::class);

    Route::get('/laporan_kegiatan/rekap/triwulan/export', function (Request $request) {
        return Excel::download(
            new RekapTriwulanExport(
                $request->tahun,
                $request->triwulan,
                $request->kegiatan_id,
                auth()->user()->id
            ),
            'rekap_triwulan.xlsx'
        );
    })->name('rekap_triwulan.export');

    Route::get('/laporan_kegiatan/rekap/tahunan/export', function (Request $request) {
        return Excel::download(
            new RekapTahunanExport(
                $request->tahun,
                $request->kegiatan_id,
                auth()->user()->id
            ),
            'rekap_tahunan.xlsx'
        );
    })->name('rekap_tahunan.export');
    
     // 🔥 CETAK PDF (INLINE DI BROWSER)
    Route::get(
        'laporan_kegiatan/{laporan}/pdf',
        [LaporanKegiatanController::class, 'pdf']
    )->name('laporan_kegiatan.pdf');

    // 🔥 ROUTE FOTO
    Route::delete(
        'laporan_kegiatan/{laporan}/foto/{index}',
        [LaporanKegiatanController::class, 'hapusFoto']
    );

    Route::post(
        'laporan_kegiatan/{laporan}/foto/{index}/replace',
        [LaporanKegiatanController::class, 'replaceFoto']
    );

    Route::post(
        'laporan_kegiatan/{laporan}/foto/tambah',
        [LaporanKegiatanController::class, 'tambahFoto']
    );
    Route::get(
        '/laporan_kegiatan/rekap/triwulan',
        [LaporanKegiatanController::class, 'rekapTriwulan']
    )->name('laporan_kegiatan.rekap_triwulan');

    Route::get(
        '/laporan_kegiatan/rekap/tahunan',
        [LaporanKegiatanController::class, 'rekapTahunan']
    )->name('laporan_kegiatan.rekap_tahunan');


});

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AsnProfileController;
use App\Http\Controllers\MasterKegiatanController;

use App\Exports\RekapTriwulanExport;
use App\Exports\RekapTahunanExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| ROUTE AUTH REQUIRED (USER AREA)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // =======================
    // USER DASHBOARD
    // =======================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =======================
    // PROFIL ASN
    // =======================
    Route::get('/profil-asn', [AsnProfileController::class, 'show'])->name('profil.asn');
    Route::get('/profil-asn/edit', [AsnProfileController::class, 'edit'])->name('profil.asn.edit');
    Route::post('/profil-asn/update', [AsnProfileController::class, 'update'])->name('profil.asn.update');

    Route::get('/profile', function () {
        return redirect()->route('profil.asn');
    });

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile/photo', [ProfileController::class, 'photo'])->name('profile.photo');

    Route::get('/keamanan-akun', function () {
        return view('profile.security');
    })->name('profile.security');

    Route::get('/pengaturan/tampilan', function () {
        return view('settings.display');
    })->name('settings.display');

    // =======================
    // MASTER KEGIATAN
    // =======================
    Route::resource('master-kegiatan', MasterKegiatanController::class);

    // =======================
    // LAPORAN KEGIATAN
    // =======================
    Route::resource('laporan_kegiatan', LaporanKegiatanController::class);

    // PDF
    Route::get(
        'laporan_kegiatan/{laporan}/pdf',
        [LaporanKegiatanController::class, 'pdf']
    )->name('laporan_kegiatan.pdf');

    
    // FOTO MANAGEMENT
    Route::delete(
        'laporan_kegiatan/{laporan}/foto/{index}',
        [LaporanKegiatanController::class, 'hapusFoto']
    );

    Route::post('/laporan_kegiatan/{id}/foto/tambah',
    [LaporanKegiatanController::class, 'tambahFoto']
    );

    Route::post(
        'laporan_kegiatan/{laporan}/foto/{index}/replace',
        [LaporanKegiatanController::class, 'updateFoto']
    );

    // =======================
    // REKAP
    // =======================
    Route::prefix('rekap')->name('rekap.')->group(function () {

        Route::get('/triwulan', [
            LaporanKegiatanController::class,
            'rekapTriwulan'
        ])->name('triwulan');

        Route::get('/tahunan', [
            LaporanKegiatanController::class,
            'rekapTahunan'
        ])->name('tahunan');

        Route::get('/triwulan/export', function (Request $request) {
            return Excel::download(
                new RekapTriwulanExport(
                    $request->tahun,
                    $request->triwulan,
                    $request->kegiatan_id,
                    auth()->id()
                ),
                'rekap_triwulan.xlsx'
            );
        })->name('triwulan.export');

        Route::get('/tahunan/export', function (Request $request) {
            return Excel::download(
                new RekapTahunanExport(
                    $request->tahun,
                    $request->kegiatan_id,
                    auth()->id()
                ),
                'rekap_tahunan.xlsx'
            );
        })->name('tahunan.export');

    });

});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','admin'])
    ->group(function () {

        // ADMIN DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class,'index'])
            ->name('dashboard');

        // USER MANAGEMENT
        Route::resource('users', AdminUserController::class);

});


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';


Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

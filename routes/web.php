<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RkaController;
use App\Http\Controllers\RkpController;
use App\Http\Controllers\SshController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\Admin\Master\UrusanController;
use App\Http\Controllers\Admin\Master\BidangUrusanController;
use App\Http\Controllers\Admin\Master\ProgramController;
use App\Http\Controllers\Admin\Master\KegiatanController;
use App\Http\Controllers\Admin\Master\KegiatanIndikatorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\Master\SubKegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\Opd\DashboardController;
use App\Http\Controllers\Opd\SshController as OpdSshController;
use App\Http\Controllers\Opd\RkpController as OpdRkpController;
use App\Http\Controllers\Opd\RkaController as OpdRkaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman publik
Route::get('/', function () {
    return view('dashboard');
})->name('back.to.home');

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Master Data routes
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/', [MasterController::class, 'index'])->name('index');
        
        // Kesejahteraan Masyarakat
        Route::get('/kesra', [MasterController::class, 'kesra'])->name('kesra');
        
        // Penegakan Hukum
        Route::get('/hukum', [MasterController::class, 'hukum'])->name('hukum');
        
        // Kesehatan
        Route::get('/kesehatan', [MasterController::class, 'kesehatan'])->name('kesehatan');

    // Urusan routes
        Route::get('/urusan/data', [UrusanController::class, 'data'])->name('urusan.data');
        Route::get('/urusan/list', [UrusanController::class, 'list'])->name('urusan.list');
        Route::post('/urusan', [UrusanController::class, 'store'])->name('urusan.store');
        Route::get('/urusan/{urusan}', [UrusanController::class, 'show'])->name('urusan.show');
        Route::put('/urusan/{urusan}', [UrusanController::class, 'update'])->name('urusan.update');
        Route::delete('/urusan/{urusan}', [UrusanController::class, 'destroy'])->name('urusan.destroy');
        
        // Bidang Urusan routes
        Route::get('/bidang-urusan/data', [BidangUrusanController::class, 'data'])->name('bidang-urusan.data');
        Route::get('/bidang-urusan/list', [BidangUrusanController::class, 'list'])->name('bidang-urusan.list');
        Route::post('/bidang-urusan', [BidangUrusanController::class, 'store'])->name('bidang-urusan.store');
        Route::get('/bidang-urusan/{bidangUrusan}', [BidangUrusanController::class, 'show'])->name('bidang-urusan.show');
        Route::put('/bidang-urusan/{bidangUrusan}', [BidangUrusanController::class, 'update'])->name('bidang-urusan.update');
        Route::delete('/bidang-urusan/{bidangUrusan}', [BidangUrusanController::class, 'destroy'])->name('bidang-urusan.destroy');
        
        // Program routes
        Route::get('/program/data', [ProgramController::class, 'data'])->name('program.data');
        Route::get('/program/list', [ProgramController::class, 'list'])->name('program.list');
        Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
        Route::get('/program/{program}', [ProgramController::class, 'show'])->name('program.show');
        Route::put('/program/{program}', [ProgramController::class, 'update'])->name('program.update');
        Route::delete('/program/{program}', [ProgramController::class, 'destroy'])->name('program.destroy');
        Route::get('/program/bidang-urusan/{kodeUrusan}', [ProgramController::class, 'getBidangUrusan'])->name('program.bidang-urusan');
        
        // Tambahkan route untuk wajib-dasar, wajib-non-dasar, pilihan, penunjang
        Route::get('/urusan/wajib-dasar', [MasterController::class, 'wajibDasar'])->name('urusan.wajib-dasar');
        Route::get('/urusan/wajib-non-dasar', [MasterController::class, 'wajibNonDasar'])->name('urusan.wajib-non-dasar');
        Route::get('/urusan/pilihan', [MasterController::class, 'pilihan'])->name('urusan.pilihan');
        Route::get('/urusan/penunjang', [MasterController::class, 'penunjang'])->name('urusan.penunjang');

        // Kegiatan routes
        Route::get('/kegiatan/data', [KegiatanController::class, 'data'])->name('kegiatan.data');
        Route::get('/kegiatan/list', [KegiatanController::class, 'list'])->name('kegiatan.list');
        Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/kegiatan/{kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');
        Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

        // Kegiatan Indikator routes
        Route::get('/kegiatan-indikator/data', [KegiatanIndikatorController::class, 'data'])->name('kegiatan-indikator.data');
        Route::get('/kegiatan-indikator/list', [KegiatanIndikatorController::class, 'list'])->name('kegiatan-indikator.list');
        Route::post('/kegiatan-indikator', [KegiatanIndikatorController::class, 'store'])->name('kegiatan-indikator.store');
        Route::get('/kegiatan-indikator/{kegiatanIndikator}', [KegiatanIndikatorController::class, 'show'])->name('kegiatan-indikator.show');
        Route::put('/kegiatan-indikator/{kegiatanIndikator}', [KegiatanIndikatorController::class, 'update'])->name('kegiatan-indikator.update');
        Route::delete('/kegiatan-indikator/{kegiatanIndikator}', [KegiatanIndikatorController::class, 'destroy'])->name('kegiatan-indikator.destroy');

        // Sub Kegiatan routes
        Route::prefix('sub-kegiatan')->name('sub-kegiatan.')->group(function () {
            Route::get('/', [SubKegiatanController::class, 'index'])->name('index');
            Route::get('/data', [SubKegiatanController::class, 'data'])->name('data');
            Route::get('/list', [SubKegiatanController::class, 'list'])->name('list');
            Route::post('/', [SubKegiatanController::class, 'store'])->name('store');
            Route::get('/{id}', [SubKegiatanController::class, 'show'])->name('show');
            Route::put('/{id}', [SubKegiatanController::class, 'update'])->name('update');
            Route::delete('/{id}', [SubKegiatanController::class, 'destroy'])->name('destroy');
            Route::get('/kegiatan/{kode_program}', [SubKegiatanController::class, 'getKegiatan'])->name('kegiatan');
        });

        // DBH CHT Routes
        Route::prefix('dbhcht')->name('dbhcht.')->group(function () {
            // Bidang Routes
            Route::get('/bidang', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'index'])->name('bidang.index');
            Route::get('/bidang/list', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'list'])->name('bidang.list');
            Route::post('/bidang', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'store'])->name('bidang.store');
            Route::get('/bidang/{id}/edit', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'edit'])->name('bidang.edit');
            Route::put('/bidang/{id}', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'update'])->name('bidang.update');
            Route::delete('/bidang/{id}', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'destroy'])->name('bidang.destroy');

            // Program Routes
            Route::get('/program', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'index'])->name('program.index');
            Route::get('/program/list', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'list'])->name('program.list');
            Route::post('/program', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'store'])->name('program.store');
            Route::get('/program/{id}/edit', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'edit'])->name('program.edit');
            Route::put('/program/{id}', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'update'])->name('program.update');
            Route::delete('/program/{id}', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'destroy'])->name('program.destroy');
            Route::get('/program/by-bidang/{bidang_id}', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'getByBidang'])->name('program.by-bidang');

            // Kegiatan Routes
            Route::get('/kegiatan', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'index'])->name('kegiatan.index');
            Route::get('/kegiatan/list', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'list'])->name('kegiatan.list');
            Route::post('/kegiatan', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'store'])->name('kegiatan.store');
            Route::get('/kegiatan/{id}/edit', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'edit'])->name('kegiatan.edit');
            Route::put('/kegiatan/{id}', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'update'])->name('kegiatan.update');
            Route::delete('/kegiatan/{id}', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'destroy'])->name('kegiatan.destroy');
            Route::get('/kegiatan/by-program/{program_id}', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'getByProgram'])->name('kegiatan.by-program');
        });
    });

    // Setting routes
    Route::prefix('setting')->name('setting.')->group(function () {
        // RKP Setting routes
        Route::prefix('rkp')->name('rkp.')->group(function () {
            Route::get('/', [SettingController::class, 'rkpIndex'])->name('index');
            Route::post('/store', [SettingController::class, 'rkpStore'])->name('store');
            Route::put('/update/{id}', [SettingController::class, 'rkpUpdate'])->name('update');
            Route::delete('/delete/{id}', [SettingController::class, 'rkpDestroy'])->name('destroy');
        });
    });

    // Manajemen Pengguna
    Route::get('/manajemenpengguna', [UserController::class, 'index'])->name('manajemenpengguna');
    Route::post('/manajemenpengguna', [UserController::class, 'store'])->name('users.store');
    Route::put('/manajemenpengguna/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/manajemenpengguna/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Verifikasi routes
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/rkp', [VerifikasiController::class, 'rkpIndex'])->name('rkp');
        Route::put('/rkp/{rkp}/approve', [VerifikasiController::class, 'rkpApprove'])->name('rkp.approve');
        Route::put('/rkp/{rkp}/revisi', [VerifikasiController::class, 'rkpRevisi'])->name('rkp.revisi');

        // RKA routes
        Route::get('/rka', [VerifikasiController::class, 'rkaIndex'])->name('rka');
        Route::put('/rka/{id}/approve', [VerifikasiController::class, 'rkaApprove'])->name('rka.approve');
        Route::put('/rka/{id}/revisi', [VerifikasiController::class, 'rkaRevisi'])->name('rka.revisi');
    });
});

// OPD routes
Route::middleware(['auth', 'role:opd'])->prefix('opd')->name('opd.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // SSH/SBU Routes
    Route::prefix('ssh')->name('ssh.')->group(function() {
        Route::get('/', [OpdSshController::class, 'index'])->name('index');
        Route::get('/data', [OpdSshController::class, 'data'])->name('data');
        Route::post('/store-custom', [OpdSshController::class, 'storeCustom'])->name('store.custom');
        Route::get('/search', [OpdSshController::class, 'search'])->name('search');
    });
    
    // RKP Routes
    Route::get('/rkp/input', [OpdRkpController::class, 'input'])->name('rkp.input');
    Route::post('/rkp/store', [OpdRkpController::class, 'store'])->name('rkp.store');
    Route::get('/rkp/perubahan', [OpdRkpController::class, 'perubahan'])->name('rkp.perubahan');
    Route::get('/rkp/perubahan/history', [OpdRkpController::class, 'history'])->name('rkp.perubahan.history');
    
    // RKA Routes
    Route::get('/rka/input', [OpdRkaController::class, 'input'])->name('rka.input');
    Route::post('/rka/store', [OpdRkaController::class, 'store'])->name('rka.store');
    Route::get('/rka/{rka}/edit', [OpdRkaController::class, 'edit'])->name('rka.edit');
    Route::delete('/rka/{rka}', [OpdRkaController::class, 'destroy'])->name('rka.destroy');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Laporan Routes
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/bulanan', [LaporanController::class, 'index'])->name('bulanan');
        Route::get('/data', [LaporanController::class, 'data'])->name('data');
        Route::get('/kegiatan', [LaporanController::class, 'kegiatan'])->name('kegiatan');
        Route::get('/kegiatan/{id}', [LaporanController::class, 'kegiatanDetail'])->name('kegiatan.detail');
        Route::post('/store', [LaporanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LaporanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [LaporanController::class, 'update'])->name('update');
        Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('destroy');
    });

    // Routes untuk Input Realisasi
    Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi.index');
    Route::get('/realisasi/create', [RealisasiController::class, 'create'])->name('realisasi.create');
    Route::post('/realisasi', [RealisasiController::class, 'store'])->name('realisasi.store');
    Route::get('/realisasi/{realisasi}/edit', [RealisasiController::class, 'edit'])->name('realisasi.edit');
    Route::put('/realisasi/{realisasi}', [RealisasiController::class, 'update'])->name('realisasi.update');
    Route::delete('/realisasi/{realisasi}', [RealisasiController::class, 'destroy'])->name('realisasi.destroy');

    // Routes untuk Ajax dropdown
    Route::get('/get-kegiatan/{program}', [RealisasiController::class, 'getKegiatan'])->name('get-kegiatan');
    Route::get('/get-sub-kegiatan/{kegiatan}', [RealisasiController::class, 'getSubKegiatan'])->name('get-sub-kegiatan');
});

// SSH Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('opd')->name('opd.')->group(function () {
        Route::get('/ssh', [App\Http\Controllers\SshController::class, 'index'])->name('ssh.index');
        Route::get('/ssh/data', [App\Http\Controllers\SshController::class, 'data'])->name('ssh.data');
    });
});

// Master Data Routes
Route::prefix('admin/master')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\MasterController::class, 'index'])->name('admin.master.index');
    
    // DBH CHT Routes
    Route::prefix('dbhcht')->group(function () {
        // Bidang Routes
        Route::get('/bidang', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'index'])->name('admin.master.bidang.index');
        Route::get('/bidang/list', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'list'])->name('admin.master.bidang.list');
        Route::post('/bidang', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'store'])->name('admin.master.bidang.store');
        Route::get('/bidang/{id}/edit', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'edit'])->name('admin.master.bidang.edit');
        Route::put('/bidang/{id}', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'update'])->name('admin.master.bidang.update');
        Route::delete('/bidang/{id}', [App\Http\Controllers\Admin\BidangDbhChtController::class, 'destroy'])->name('admin.master.bidang.destroy');

        // Program Routes
        Route::get('/program', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'index'])->name('admin.master.program.index');
        Route::get('/program/list', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'list'])->name('admin.master.program.list');
        Route::post('/program', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'store'])->name('admin.master.program.store');
        Route::get('/program/{id}/edit', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'edit'])->name('admin.master.program.edit');
        Route::put('/program/{id}', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'update'])->name('admin.master.program.update');
        Route::delete('/program/{id}', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'destroy'])->name('admin.master.program.destroy');
        Route::get('/program/by-bidang/{bidang_id}', [App\Http\Controllers\Admin\ProgramDbhChtController::class, 'getByBidang'])->name('admin.master.program.by-bidang');

        // Kegiatan Routes
        Route::get('/kegiatan', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'index'])->name('admin.master.kegiatan.index');
        Route::get('/kegiatan/list', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'list'])->name('admin.master.kegiatan.list');
        Route::post('/kegiatan', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'store'])->name('admin.master.kegiatan.store');
        Route::get('/kegiatan/{id}/edit', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'edit'])->name('admin.master.kegiatan.edit');
        Route::put('/kegiatan/{id}', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'update'])->name('admin.master.kegiatan.update');
        Route::delete('/kegiatan/{id}', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'destroy'])->name('admin.master.kegiatan.destroy');
        Route::get('/kegiatan/by-program/{program_id}', [App\Http\Controllers\Admin\KegiatanDbhChtController::class, 'getByProgram'])->name('admin.master.kegiatan.by-program');
    });
});

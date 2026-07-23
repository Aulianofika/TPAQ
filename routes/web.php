<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\SantriController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/program', [HomeController::class, 'program'])->name('program');
Route::get('/pengurus', [HomeController::class, 'pengurus'])->name('pengurus');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/pengumuman', [HomeController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [HomeController::class, 'pengumumanDetail'])->name('pengumuman.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rute Lupa & Reset Password
Route::get('/lupa-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Authenticated Routes (Guru & Admin)
Route::prefix('admin')->middleware(['auth', 'guru'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Bagian Guru (Accessible by Guru & Admin)
    Route::get('/presensi', [AbsensiController::class, 'index'])->name('admin.presensi');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('admin.absensi');
    Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('admin.absensi.rekap');
    Route::get('/absensi/rekap/pdf', [AbsensiController::class, 'cetakPdf'])->name('admin.absensi.pdf');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('admin.absensi.store');

    // E-Rapor
    Route::get('/eraport', [\App\Http\Controllers\Admin\EraportController::class, 'index'])->name('admin.eraport');
    Route::get('/eraport/riwayat', [\App\Http\Controllers\Admin\EraportController::class, 'riwayat'])->name('admin.eraport.riwayat');
    Route::post('/eraport', [\App\Http\Controllers\Admin\EraportController::class, 'store'])->name('admin.eraport.store');
    Route::get('/eraport/pdf/{id}', [\App\Http\Controllers\Admin\EraportController::class, 'cetakPdf'])->name('admin.eraport.pdf');
    Route::get('/eraport/preview/{id}', [\App\Http\Controllers\Admin\EraportController::class, 'previewPdf'])->name('admin.eraport.preview');
    Route::get('/eraport/get-absensi', [\App\Http\Controllers\Admin\EraportController::class, 'getAbsensi'])->name('admin.eraport.get_absensi');
    Route::delete('/eraport/{id}', [\App\Http\Controllers\Admin\EraportController::class, 'destroy'])->name('admin.eraport.delete');

    // Hafalan
    Route::get('/hafalan', [\App\Http\Controllers\Admin\HafalanController::class, 'index'])->name('admin.hafalan');
    Route::post('/hafalan/target', [\App\Http\Controllers\Admin\HafalanController::class, 'storeTarget'])->name('admin.hafalan.target.store');
    Route::post('/hafalan/progress', [\App\Http\Controllers\Admin\HafalanController::class, 'storeProgress'])->name('admin.hafalan.progress.store');
    Route::get('/hafalan/riwayat/{id_santri}', [\App\Http\Controllers\Admin\HafalanController::class, 'getRiwayat'])->name('admin.hafalan.riwayat');

    // Progress Santri
    Route::get('/santri/progress', [\App\Http\Controllers\Admin\SantriProgressController::class, 'index'])->name('admin.santri.progress');
    Route::get('/santri/progress/{id}', [\App\Http\Controllers\Admin\SantriProgressController::class, 'show'])->name('admin.santri.progress.show');


    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        Route::get('/iuran', [\App\Http\Controllers\Admin\IuranController::class, 'index'])->name('admin.iuran');
        Route::post('/iuran', [\App\Http\Controllers\Admin\IuranController::class, 'store'])->name('admin.iuran.store');
        Route::put('/iuran/{id}', [\App\Http\Controllers\Admin\IuranController::class, 'update'])->name('admin.iuran.update');
        Route::delete('/iuran/{id}', [\App\Http\Controllers\Admin\IuranController::class, 'destroy'])->name('admin.iuran.destroy');

        // Kelas CRUD
        Route::get('/kelas', [\App\Http\Controllers\Admin\KelasController::class, 'index'])->name('admin.kelas.index');
        Route::post('/kelas', [\App\Http\Controllers\Admin\KelasController::class, 'store'])->name('admin.kelas.store');
        Route::put('/kelas/{id}', [\App\Http\Controllers\Admin\KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('/kelas/{id}', [\App\Http\Controllers\Admin\KelasController::class, 'destroy'])->name('admin.kelas.destroy');

        // Santri CRUD
        Route::get('/santri', [SantriController::class, 'index'])->name('admin.santri.index');
        Route::post('/santri', [SantriController::class, 'store'])->name('admin.santri.store');
        Route::put('/santri/{santri}', [SantriController::class, 'update'])->name('admin.santri.update');
        Route::delete('/santri/{santri}', [SantriController::class, 'destroy'])->name('admin.santri.destroy');

        // Pengajar CRUD
        Route::get('/pengajar', [\App\Http\Controllers\Admin\PengajarController::class, 'index'])->name('admin.pengajar');
        Route::post('/pengajar', [\App\Http\Controllers\Admin\PengajarController::class, 'store'])->name('admin.pengajar.store');
        Route::put('/pengajar/{id}', [\App\Http\Controllers\Admin\PengajarController::class, 'update'])->name('admin.pengajar.update');
        Route::post('/pengajar/{id}/akun', [\App\Http\Controllers\Admin\PengajarController::class, 'createAccount'])->name('admin.pengajar.akun');
        Route::delete('/pengajar/{id}', [\App\Http\Controllers\Admin\PengajarController::class, 'destroy'])->name('admin.pengajar.destroy');

        // Pengurus CRUD
        Route::get('/pengurus', [\App\Http\Controllers\Admin\PengurusController::class, 'index'])->name('admin.pengurus');
        Route::post('/pengurus', [\App\Http\Controllers\Admin\PengurusController::class, 'store'])->name('admin.pengurus.store');
        Route::put('/pengurus/{id}', [\App\Http\Controllers\Admin\PengurusController::class, 'update'])->name('admin.pengurus.update');
        Route::post('/pengurus/{id}/akun', [\App\Http\Controllers\Admin\PengurusController::class, 'createAccount'])->name('admin.pengurus.akun');
        Route::delete('/pengurus/{id}', [\App\Http\Controllers\Admin\PengurusController::class, 'destroy'])->name('admin.pengurus.destroy');

        // Galeri CRUD
        Route::get('/galeri', [\App\Http\Controllers\Admin\GaleriController::class, 'index'])->name('admin.galeri');
        Route::post('/galeri', [\App\Http\Controllers\Admin\GaleriController::class, 'store'])->name('admin.galeri.store');
        Route::put('/galeri/{id}', [\App\Http\Controllers\Admin\GaleriController::class, 'update'])->name('admin.galeri.update');
        Route::delete('/galeri/{id}', [\App\Http\Controllers\Admin\GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

        // Pengumuman CRUD
        Route::get('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'index'])->name('admin.pengumuman');
        Route::post('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'store'])->name('admin.pengumuman.store');
        Route::put('/pengumuman/{id}', [\App\Http\Controllers\Admin\PengumumanController::class, 'update'])->name('admin.pengumuman.update');
        Route::delete('/pengumuman/{id}', [\App\Http\Controllers\Admin\PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');
    });
});

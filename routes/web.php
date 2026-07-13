<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KaryawanProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Halaman login
Route::get('/', [AuthController::class, 'showLogin'])->name('landing');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua halaman aplikasi wajib login dulu
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('pengaturan')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

    // Halaman "Data Diri" khusus untuk role Karyawan mengedit datanya sendiri
    // (no. telp, alamat, tanggal lahir, jenis kelamin). Field administratif
    // (NIP, nama, departemen, jabatan, gaji, status) tetap dikunci di sini.
    Route::get('/data-diri', [KaryawanProfileController::class, 'edit'])->name('karyawan.profile.edit');
    Route::put('/data-diri', [KaryawanProfileController::class, 'update'])->name('karyawan.profile.update');

    // Slip Gaji: khusus tampilan milik sendiri untuk role Karyawan.
    Route::get('/slip-gaji', [KaryawanProfileController::class, 'payslip'])->name('karyawan.payslip');

    // Halaman "karyawan" bisa dilihat SEMUA role yang login (Admin & Karyawan).
    // Aksi tambah/edit/hapus/impor/ekspor dibatasi khusus Admin lewat middleware 'admin' per-route.
    // PENTING: rute statis (create, import, export, bulk-delete) HARUS didaftarkan
    // sebelum rute wildcard '/{karyawan}' agar tidak salah tangkap oleh route show.
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('index');
        Route::get('/create', [KaryawanController::class, 'create'])->name('create')->middleware('admin');
        Route::post('/', [KaryawanController::class, 'store'])->name('store')->middleware('admin');
        Route::get('/import', [KaryawanController::class, 'importForm'])->name('import.form')->middleware('admin');
        Route::post('/import', [KaryawanController::class, 'import'])->name('import')->middleware('admin');
        Route::get('/import/template', [KaryawanController::class, 'downloadTemplate'])->name('import.template')->middleware('admin');
        Route::get('/export/excel', [KaryawanController::class, 'exportExcel'])->name('export.excel')->middleware('admin');
        Route::get('/export/csv', [KaryawanController::class, 'exportCsv'])->name('export.csv')->middleware('admin');
        Route::delete('/bulk-delete', [KaryawanController::class, 'bulkDestroy'])->name('bulkDestroy')->middleware('admin');
        Route::get('/{karyawan}', [KaryawanController::class, 'show'])->name('show');
        Route::get('/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('edit')->middleware('admin');
        Route::put('/{karyawan}', [KaryawanController::class, 'update'])->name('update')->middleware('admin');
        Route::delete('/{karyawan}', [KaryawanController::class, 'destroy'])->name('destroy')->middleware('admin');
    });

    // Halaman-halaman berikut khusus untuk role Admin
    Route::middleware('admin')->group(function () {
        Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');

        Route::prefix('departemen')->name('departemen.')->group(function () {
            Route::get('/', [DepartemenController::class, 'index'])->name('index');
            Route::get('/create', [DepartemenController::class, 'create'])->name('create');
            Route::post('/', [DepartemenController::class, 'store'])->name('store');
            Route::get('/{departemen}/edit', [DepartemenController::class, 'edit'])->name('edit');
            Route::put('/{departemen}', [DepartemenController::class, 'update'])->name('update');
            Route::delete('/{departemen}', [DepartemenController::class, 'destroy'])->name('destroy');
        });
    });
});

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JadwalKlarifikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


// ================= ADMIN =================
Route::middleware(['auth', 'admin'])->group(function () {

    // Daftar user
    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    // Form tambah user
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])
        ->name('admin.users.create');

    // Simpan user baru
    Route::post('/admin/users', [AdminUserController::class, 'store'])
        ->name('admin.users.store');

    // Hapus user
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])
        ->name('admin.users.destroy');

    // Daftar activity log
        Route::get('/admin/logs', [AdminActivityLogController::class, 'index'])
    ->name('admin.logs.index');

});


Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // CHANGE PASSWORD
    Route::get('/change-password', function () {
        return view('profile.change-password');
    })->name('password.edit');

    Route::put('/change-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');


    // ================= JADWAL =================
    Route::resource('jadwal', JadwalKlarifikasiController::class);

    // UPDATE HASIL KEGIATAN
    Route::patch('/jadwal/{id}/update-hasil',
        [JadwalKlarifikasiController::class, 'updateHasil']
    )->name('jadwal.updateHasil');


    // ================= MONITORING NOTIFIKASI =================
    Route::get('/monitoring-notifikasi',
        [MonitoringController::class, 'index']
    )->name('monitoring.notifikasi');

});

require __DIR__.'/auth.php';

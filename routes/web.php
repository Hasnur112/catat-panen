<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\VarietasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\GlobalDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard & Profil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Panen CRUD (Petani)
    Route::resource('panen', PanenController::class)->except(['show']);

    // Lihat data petani (Read-only)
    Route::get('/petani', [PetaniController::class, 'index'])->name('petani.index');
    Route::get('/petani/{petani}', [PetaniController::class, 'show'])->name('petani.show');

    // =====================
    // Admin routes
    // =====================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Kelola pengguna
        Route::resource('users', UserController::class)->except(['show']);

        // Verifikasi Panen (Hanya akses list dan update status)
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::put('panen/{panen}/status', [VerifikasiController::class, 'updateStatus'])->name('panen.updateStatus');
        Route::post('verifikasi/verify-all', [VerifikasiController::class, 'verifyAll'])->name('verifikasi.verifyAll');

        // Master data varietas
        Route::resource('varietas', VarietasController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    // =====================
    // Super Admin routes
    // =====================
    Route::middleware('super_admin')->prefix('super-admin')->name('super_admin.')->group(function () {
        Route::get('dashboard', [GlobalDashboardController::class, 'index'])->name('dashboard');
        Route::get('users', [GlobalDashboardController::class, 'users'])->name('users');
        Route::patch('users/{user}/role', [GlobalDashboardController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('users/{user}', [GlobalDashboardController::class, 'destroyUser'])->name('users.destroy');
    });
});

require __DIR__ . '/auth.php';
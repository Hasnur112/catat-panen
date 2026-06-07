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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Panen CRUD (petani)
    Route::resource('panen', PanenController::class)->except(['show']);

    // Lihat panen petani lain (read-only, semua role)
    Route::get('/petani', [PetaniController::class, 'index'])->name('petani.index');
    Route::get('/petani/{petani}', [PetaniController::class, 'show'])->name('petani.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =====================
    // Admin routes
    // =====================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Kelola pengguna
        Route::resource('users', UserController::class)->except(['show']);

        // Verifikasi panen
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('verifikasi/{panen}/verify', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        Route::post('verifikasi/verify-all', [VerifikasiController::class, 'verifyAll'])->name('verifikasi.verifyAll');
        Route::get('verifikasi/{panen}/edit', [VerifikasiController::class, 'edit'])->name('verifikasi.edit');
        Route::put('verifikasi/{panen}', [VerifikasiController::class, 'update'])->name('verifikasi.update');
        Route::delete('verifikasi/{panen}', [VerifikasiController::class, 'destroy'])->name('verifikasi.destroy');

        // Master data varietas
        Route::get('varietas', [VarietasController::class, 'index'])->name('varietas.index');
        Route::post('varietas', [VarietasController::class, 'store'])->name('varietas.store');
        Route::put('varietas/{varieta}', [VarietasController::class, 'update'])->name('varietas.update');
        Route::delete('varietas/{varieta}', [VarietasController::class, 'destroy'])->name('varietas.destroy');
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

<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\KomenController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\GradeController;

// Route untuk halaman selamat datang
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk halaman dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route jumlah user di dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk profil pengguna
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImage'); // Rute untuk update gambar
    Route::delete('/profile/delete-image', [ProfileController::class, 'deleteImage'])->name('profile.deleteImage'); // Rute untuk hapus gambar
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Rute untuk guru
    Route::middleware(CheckRole::class . ':guru')->group(function () {
        Route::prefix('themes')->group(function () {
            Route::get('/', [ThemeController::class, 'index'])->name('themes.index');
            Route::get('create', [ThemeController::class, 'create'])->name('themes.create');
            Route::post('store', [ThemeController::class, 'store'])->name('themes.store');
            Route::get('{theme}/edit', [ThemeController::class, 'edit'])->name('themes.edit');
            Route::put('{theme}', [ThemeController::class, 'update'])->name('themes.update');
            Route::delete('{theme}', [ThemeController::class, 'destroy'])->name('themes.destroy');
        });

        // Rute untuk grade
        Route::prefix('grades')->group(function () {
            Route::get('/', [GradeController::class, 'index'])->name('grades.index');
            Route::get('create', [GradeController::class, 'create'])->name('grades.create');
            Route::post('store', [GradeController::class, 'store'])->name('grades.store');
            Route::get('{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
            Route::put('{grade}', [GradeController::class, 'update'])->name('grades.update');
            Route::delete('{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
        });
    });

    // Rute untuk menampilkan halaman chart
Route::get('/grades/chart', [ChartController::class, 'showChart'])->name('grades.chart');

    // Rute untuk diskusi
    Route::get('/diskusi', [KomenController::class, 'index'])->name('komen.index');
    Route::post('/diskusi', [KomenController::class, 'store'])->name('komen.store');
    Route::delete('/komen{id}', [KomenController::class, 'destroy'])->name('komen.destroy');
});

// Routes yang tidak memerlukan autentikasi
require __DIR__ . '/auth.php';

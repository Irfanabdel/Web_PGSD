<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\KomenController;

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
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
        Route::delete('/nilai/{id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
        Route::get('/nilai/{id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('nilai.update');
    });

    // Rute untuk semua pengguna
    Route::get('/nilai/chart', [ChartController::class, 'showChart'])->name('nilai.chart');
    //Rute untuk nilai kosong
    Route::get('/nilai/empty', [NilaiController::class, 'empty'])->name('nilai.empty');
    // Rute untuk menampilkan grafik nilai
    Route::get('/nilai/chart', [ChartController::class, 'showSiswaNilai'])->name('nilai.chart');
    // Rute untuk diskusi
    Route::get('/diskusi', [KomenController::class, 'index'])->name('komen.index');
    Route::post('/diskusi', [KomenController::class, 'store'])->name('komen.store');
    Route::delete('/komen{id}', [KomenController::class, 'destroy'])->name('komen.destroy');


    Route::get('/nilai/dashboard', function () {
        return view('dashboard');
    })->name('nilai.dashboard');
});

// Routes yang tidak memerlukan autentikasi
require __DIR__ . '/auth.php';

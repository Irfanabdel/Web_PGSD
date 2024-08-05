<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
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

// Route untuk profil pengguna
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(CheckRole::class . ':guru')->group(function () {
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
        Route::delete('/nilai/{id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
        Route::get('/nilai/{id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('nilai.update');
    });
    
    Route::get('/nilai/chart', [ChartController::class, 'showChart'])->name('nilai.chart');


    Route::middleware(['auth', 'verified'])->group(function () {
        // Rute untuk menampilkan grafik nilai
        Route::get('/nilai/chart', [ChartController::class, 'showSiswaNilai'])->name('nilai.chart');
        
Route::get('/diskusi', [KomenController::class, 'index'])->name('komen.index');
     });
    

    Route::get('/nilai/dashboard', function () {
        return view('dashboard');
    })->name('nilai.dashboard');

    Route::get('/nilai/komen', function () {
        return view('nilai.komen');
    })->name('nilai.komen');
});






// Routes yang tidak memerlukan autentikasi
require __DIR__.'/auth.php';

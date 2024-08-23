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
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ModuleController;
use App\Models\Module;

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

        // Kelompokkan rute dengan prefix 'learnings'
        Route::prefix('learnings')->name('learnings.')->group(function () {
            Route::get('/', [LearningController::class, 'index'])->name('index');
            Route::get('create', [LearningController::class, 'create'])->name('create');
            Route::post('store/step1', [LearningController::class, 'storeStep1'])->name('store.step1');
            Route::get('create/step2', [LearningController::class, 'createStep2'])->name('create.step2');
            Route::get('/reset-step1', [LearningController::class, 'resetStep1Data'])->name('reset.step1');
            Route::get('{learning}', [LearningController::class, 'show'])->name('show'); // Rute show untuk halaman detail
            // Menambahkan rute untuk edit, update, dan delete
            Route::get('{learning}/edit', [LearningController::class, 'edit'])->name('edit.step1'); // Rute edit langkah 1
            Route::put('{learning}', [LearningController::class, 'update'])->name('update'); // Rute update
            // Rute edit dan update untuk step 2
            Route::get('{learning}/edit-step2', [ModuleController::class, 'editStep2'])->name('edit.step2');
            Route::put('{learning}/update-step2', [ModuleController::class, 'updateStep2'])->name('update.step2');
            Route::delete('{learning}', [LearningController::class, 'destroy'])->name('destroy'); // Rute delete
        });

        Route::prefix('modules')->name('modules.')->group(function () {
            Route::get('create-step2', [ModuleController::class, 'createStep2'])->name('create.step2');
            Route::post('store-step2', [ModuleController::class, 'storeStep2'])->name('store.step2');
            Route::put('{module}/update-step2', [ModuleController::class, 'updateStep2'])->name('update.step2');
            Route::delete('{module}', [ModuleController::class, 'destroy'])->name('destroy');
            Route::get('create', [LearningController::class, 'create'])->name('create');
        });
    });

    // Kelompokkan rute dengan prefix 'learnings'
    Route::prefix('learnings')->name('learnings.')->group(function () {
        Route::get('/', [LearningController::class, 'index'])->name('index');
        Route::get('{learning}', [LearningController::class, 'show'])->name('show'); // Rute show untuk siswa
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

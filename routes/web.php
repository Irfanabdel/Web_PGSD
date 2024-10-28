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
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\TeacherController;

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

        // Rute untuk teacher
        Route::prefix('teachers')->group(function () {
            Route::get('/', [TeacherController::class, 'index'])->name('teachers.index');
            Route::get('create', [TeacherController::class, 'create'])->name('teachers.create');
            Route::post('store', [TeacherController::class, 'store'])->name('teachers.store');
            Route::get('{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
            Route::put('{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
            Route::delete('{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
        });

        // Kelompokkan rute dengan prefix 'learnings'
        Route::prefix('learnings')->name('learnings.')->group(function () {
            Route::get('/', [LearningController::class, 'index'])->name('index');
            Route::get('create', [LearningController::class, 'create'])->name('create');
            Route::post('store/step1', [LearningController::class, 'storeStep1'])->name('store.step1');
            Route::get('/reset-step1', [LearningController::class, 'resetStep1Data'])->name('reset.step1');

            Route::get('{learning}', [LearningController::class, 'show'])->name('show'); // Halaman detail

            // Rute Edit, Update, dan Delete Step 1
            Route::get('{learning}/edit', [LearningController::class, 'edit'])->name('edit.step1');
            Route::put('{learning}', [LearningController::class, 'update'])->name('update');
            Route::delete('{learning}', [LearningController::class, 'destroy'])->name('destroy');

            // Rute Create dan Edit untuk Step 2 (Module)
            Route::get('{learning}/create/step2', [ModuleController::class, 'createStep2'])->name('create.step2');
            Route::post('{learning}/store/step2', [ModuleController::class, 'storeStep2'])->name('store.step2');
            Route::get('{learning}/edit-step2/{module}', [ModuleController::class, 'editStep2'])->name('edit.step2');
            Route::put('{learning}/update-step2/{module}', [ModuleController::class, 'updateStep2'])->name('update.step2'); // Rute untuk update
            Route::delete('{learning}/modules/{module}', [ModuleController::class, 'destroy'])->name('destroy.module'); // Rute untuk delete module


            // Rute Evaluasi terkait Modul
            Route::prefix('{learning}/modules/{module}')->group(function () {
                Route::get('create-step3', [EvaluationController::class, 'createStep3'])->name('create.step3'); // Halaman untuk membuat evaluasi
                Route::post('store-step3', [EvaluationController::class, 'storeStep3'])->name('store.step3'); // Menyimpan evaluasi baru
                Route::get('evaluations/{evaluation}/edit', [EvaluationController::class, 'editStep3'])->name('edit.step3'); // Halaman untuk mengedit evaluasi
                Route::put('evaluations/{evaluation}', [EvaluationController::class, 'updateStep3'])->name('update.step3'); // Memperbarui evaluasi
                Route::delete('evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('destroy.evaluation'); // Menghapus evaluasi
            });

            // Rute untuk upload file evaluasi
            Route::post('evaluations/files', [EvaluationController::class, 'evaluationFiles'])->name('evaluation.files');

            // Rute untuk pekerjaan (works)
            Route::get('evaluations/{evaluation}/works', [WorkController::class, 'createWork'])->name('work');
            Route::post('evaluations/{evaluation}/works', [WorkController::class, 'storeWork'])->name('store.work');
        });
    });

    // Rute yang bisa diakses oleh semua user
    Route::prefix('learnings')->name('learnings.')->group(function () {
        Route::get('/', [LearningController::class, 'index'])->name('index');
        Route::get('{learning}', [LearningController::class, 'show'])->name('show'); // Rute show untuk siswa
        // Rute untuk halaman kerja dan penyimpanan jawaban pekerjaan
        Route::get('evaluations/{evaluation}/works', [WorkController::class, 'createWork'])->name('work');
        Route::post('evaluations/{evaluation}/works', [WorkController::class, 'storeWork'])->name('store.work');
        // Rute untuk meng-handle upload file evaluasi
        Route::post('evaluations/files', [EvaluationController::class, 'evaluationFiles'])->name('evaluation.files');
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

<?php

use App\Http\Controllers\BiotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\KontenEdukasiController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kuis', [QuizController::class, 'index'])->name('kuis.index');
    Route::middleware('throttle:kuis')->group(function () {
        Route::post('/kuis/mulai', [QuizController::class, 'mulai'])->name('kuis.mulai');
        Route::post('/kuis/{game}/jawab', [QuizController::class, 'jawab'])->name('kuis.jawab');
        Route::post('/kuis/{game}/selesai', [QuizController::class, 'selesai'])->name('kuis.selesai');
    });

    Route::post('/biota/{biota:slug}/komentar', [KomentarController::class, 'store'])
        ->middleware('throttle:10,1')           // maksimal 10 komentar per menit per pengguna
        ->name('komentar.store');

    Route::get('/komentar/{komentar}/edit', [KomentarController::class, 'edit'])->name('komentar.edit');
    Route::put('/komentar/{komentar}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::delete('/komentar/{komentar}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
});

Route::get('/biota', [BiotaController::class, 'index'])->name('biota.index');
Route::get('/biota/{biota:slug}', [BiotaController::class, 'show'])->name('biota.show');

Route::get('/edukasi', [KontenEdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{konten:slug}', [KontenEdukasiController::class, 'show'])->name('edukasi.show');

Route::get('/koleksi', [KartuController::class, 'index'])->name('kartu.index')->middleware('auth');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
require __DIR__ . '/auth.php';

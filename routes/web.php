<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiotaController;
use App\Http\Controllers\KontenEdukasiController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/biota', [BiotaController::class, 'index'])->name('biota.index');
Route::get('/biota/{biota:slug}', [BiotaController::class, 'show'])->name('biota.show');

Route::get('/edukasi', [KontenEdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{konten:slug}', [KontenEdukasiController::class, 'show'])->name('edukasi.show');

Route::get('/koleksi', [KartuController::class, 'index'])->name('kartu.index')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/kuis', [QuizController::class, 'index'])->name('kuis.index');
    Route::post('/kuis/mulai', [QuizController::class, 'mulai'])->name('kuis.mulai');
    Route::post('/kuis/{game}/jawab', [QuizController::class, 'jawab'])->name('kuis.jawab');
    Route::post('/kuis/{game}/selesai', [QuizController::class, 'selesai'])->name('kuis.selesai');
});
require __DIR__ . '/auth.php';

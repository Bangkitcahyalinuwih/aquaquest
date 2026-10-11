<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BiotaAdminController;
use App\Http\Controllers\Admin\KontenEdukasiAdminController;
use App\Http\Controllers\Admin\KartuAdminController;
use App\Http\Controllers\Admin\SoalKuisAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

Route::resource('biota', BiotaAdminController::class)
    ->parameters(['biota' => 'biota'])
    ->except('show');

Route::resource('edukasi', KontenEdukasiAdminController::class)
    ->parameters(['edukasi' => 'konten'])
    ->except('show');

Route::resource('soal', SoalKuisAdminController::class)
    ->parameters(['soal' => 'soal'])
    ->except('show');

Route::resource('kartu', KartuAdminController::class)
    ->parameters(['kartu' => 'kartu'])
    ->except('show');

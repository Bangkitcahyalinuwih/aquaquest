<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BiotaAdminController;
use App\Http\Controllers\Admin\KontenEdukasiAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

Route::resource('biota', BiotaAdminController::class)
    ->parameters(['biota' => 'biota'])
    ->except('show');

Route::resource('edukasi', KontenEdukasiAdminController::class)
    ->parameters(['edukasi' => 'konten'])
    ->except('show');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BiotaAdminController;
use App\Http\Controllers\Admin\KontenEdukasiAdminController;

Route::resource('biota', BiotaAdminController::class)->parameters([
    'biota' => 'biota'
]);
Route::resource('edukasi', KontenEdukasiAdminController::class);

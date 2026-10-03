<?php

use Illuminate\Support\Facades\Route;

// Saat orang membuka alamat web utama (/), tampilkan file 'welcome.blade.php'
Route::get('/', function () {
    return view('welcome');
});
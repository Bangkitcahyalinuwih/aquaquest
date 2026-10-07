<?php

use App\Models\User;
use App\Models\Biota;

test('user biasa tidak bisa akses admin biota', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)->get('/admin/biota')->assertForbidden();
});

test('admin bisa lihat daftar biota', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->get('/admin/biota')->assertOk();
});
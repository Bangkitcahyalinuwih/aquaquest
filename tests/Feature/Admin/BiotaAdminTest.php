<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

test('user biasa tidak bisa akses admin biota', function () {
    $user = User::factory()->create(['role' => 'user']);

    actingAs($user)->get('/admin/biota')->assertForbidden();
});

test('admin bisa lihat daftar biota', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)->get('/admin/biota')->assertOk();
});

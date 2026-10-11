<?php

use App\Models\User;

test('admin diarahkan ke dashboard admin setelah login', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->post('/login', ['email' => $admin->email, 'password' => 'password'])
        ->assertRedirect('/admin');
});

test('user biasa diarahkan ke dashboard setelah login', function () {
    $user = User::factory()->create();

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect('/dashboard');
});

test('tamu yang membuka kuis diarahkan ke login', function () {
    $this->get('/kuis')->assertRedirect('/login');
});

test('setelah login, pengguna kembali ke halaman tujuan semula', function () {
    $user = User::factory()->create();

    // "url.intended" adalah kunci sesi yang diisi Laravel saat tamu ditolak di halaman terproteksi.
    $this->withSession(['url.intended' => url('/kuis')])
        ->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect('/kuis');
});

test('admin yang membuka dashboard user dialihkan ke dashboard admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin');
});

test('user biasa mendapat 403 di halaman admin', function (string $nama) {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)->get(route($nama))->assertForbidden();
})->with(['admin.dashboard', 'admin.biota.index', 'admin.edukasi.index']);

test('tamu diarahkan ke login dari halaman admin', function (string $nama) {
    $this->get(route($nama))->assertRedirect('/login');
})->with(['admin.dashboard', 'admin.biota.index', 'admin.edukasi.index']);

test('halaman publik dapat dibuka tamu', function (string $url) {
    $this->withoutExceptionHandling(); // <--- TAMBAHKAN BARIS INI SEMENTARA

    $this->get($url)->assertOk();
})->with(['/', '/biota', '/edukasi', '/login', '/register']);
test('halaman yang tidak ada menampilkan 404', function () {
    $this->get('/halaman-tidak-ada')->assertNotFound();
});

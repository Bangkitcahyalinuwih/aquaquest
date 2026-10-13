<?php

use App\Models\Biota;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;

test('user biasa tidak bisa akses admin biota', function () {
    $user = User::factory()->create(['role' => 'user']);

    actingAs($user)->get('/admin/biota')->assertForbidden();
});

test('admin bisa lihat daftar biota', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)->get('/admin/biota')->assertOk();
});

test('admin dapat menambah biota dengan gambar', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->post(route('admin.biota.store'), [
        'nama' => 'Penyu Uji',
        'kategori' => 'Reptil Laut',
        'deskripsi' => 'Deskripsi uji',
        'gambar' => UploadedFile::fake()->image('penyu.jpg', 600, 400),
    ])->assertRedirect(route('admin.biota.index'));

    $biota = Biota::where('nama', 'Penyu Uji')->firstOrFail();

    expect($biota->slug)->toBe('penyu-uji');
    Storage::disk('public')->assertExists($biota->gambar);
});

test('nama biota yang sama menghasilkan slug berbeda', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $data = ['nama' => 'Ikan Sama', 'kategori' => 'Ikan', 'deskripsi' => 'x'];

    $this->actingAs($admin)->post(route('admin.biota.store'), $data);
    $this->actingAs($admin)->post(route('admin.biota.store'), $data);

    expect(Biota::pluck('slug')->sort()->values()->all())->toBe(['ikan-sama', 'ikan-sama-2']);
});

test('admin dapat mengubah dan menghapus biota', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $biota = Biota::factory()->create();

    $this->actingAs($admin)->put(route('admin.biota.update', $biota), [
        'nama' => 'Nama Baru',
        'kategori' => 'Ikan',
        'deskripsi' => 'Baru',
    ])->assertRedirect(route('admin.biota.index'));

    expect($biota->fresh()->nama)->toBe('Nama Baru');

    $this->actingAs($admin)->delete(route('admin.biota.destroy', $biota->fresh()));
    $this->assertDatabaseMissing('biota', ['id' => $biota->id]);
});

test('gambar yang bukan gambar ditolak', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->post(route('admin.biota.store'), [
        'nama' => 'X',
        'kategori' => 'Ikan',
        'deskripsi' => 'x',
        'gambar' => UploadedFile::fake()->create('virus.php', 10, 'application/x-php'),
    ])->assertSessionHasErrors('gambar');
});

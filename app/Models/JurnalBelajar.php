<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalBelajar extends Model
{
    // Nama tabel ditulis eksplisit karena aturan jamak Laravel akan menebak "jurnal_belajars"
    protected $table = 'jurnal_belajar';

    // Daftar kolom yang diizinkan diisi secara massal lewat create() atau update()
    protected $fillable = [
        'user_id', 
        'konten_edukasi_id', 
        'ringkasan', 
        'rating', 
        'status', 
        'target_selesai'
    ];

    // Otomatis ubah format kolom tanggal dari database menjadi objek Carbon/Date PHP
    protected $casts = [
        'target_selesai' => 'date',
    ];

    // Relasi Many-to-One: Satu catatan jurnal dimiliki oleh satu User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Many-to-One: Satu catatan jurnal merujuk pada satu artikel KontenEdukasi
    public function kontenEdukasi(): BelongsTo
    {
        return $this->belongsTo(KontenEdukasi::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jurnal extends Model
{
    // Daftar kolom yang diizinkan untuk diisi oleh user lewat form
    protected $fillable = [
        'user_id',
        'nama_biota',
        'lokasi',
        'kondisi',
        'catatan',
    ];

    // Relasi: Setiap 1 Jurnal pasti dimiliki oleh 1 User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
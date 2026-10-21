<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalBelajar extends Model
{
    protected $table = 'jurnal_belajar';

    protected $fillable = ['user_id', 'konten_edukasi_id', 'ringkasan', 'rating', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kontenEdukasi(): BelongsTo
    {
        return $this->belongsTo(KontenEdukasi::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontenEdukasi extends Model
{
    use HasFactory;

    protected $table = 'konten_edukasi';   // nama tabelnya jamak tidak standar, jadi ditulis manual

    protected $fillable = ['biota_id', 'judul', 'slug', 'isi', 'gambar'];

    // Kebalikan dari relasi di atas: satu konten edukasi MILIK satu biota (atau tidak sama sekali).
    public function biota(): BelongsTo
    {
        return $this->belongsTo(Biota::class);
    }
}
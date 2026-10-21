<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';

    protected $fillable = ['biota_id', 'user_id', 'isi'];

    public function biota(): BelongsTo
    {
        return $this->belongsTo(Biota::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

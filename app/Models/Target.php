<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul_target',
        'kategori',
        'ref_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
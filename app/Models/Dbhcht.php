<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dbhcht extends Model
{
    use HasFactory;

    protected $table = 'dbhcht';

    protected $fillable = [
        'kode',
        'program',
        'kegiatan',
        'keterangan',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
} 
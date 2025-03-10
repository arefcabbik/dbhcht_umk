<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanaMaster extends Model
{
    use HasFactory;

    protected $table = 'dana_masters';
    protected $fillable = [
        'tahun',
        'nominal',
    ];

}

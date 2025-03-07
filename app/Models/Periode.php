<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    
    protected $fillable = [
        'nama',
        'tahun',
        'aktif'
    ];

    public function periodeRKP()
    {
        return $this->hasMany(PeriodeRKP::class);
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{
    use HasFactory;

    protected $table = 'realisasis';
    
    protected $fillable = [
        'program_id',
        'kegiatan_id',
        'sub_kegiatan_id',
        'bulan',
        'tahun',
        'realisasi_anggaran',
        'realisasi_fisik',
        'keterangan'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }
} 
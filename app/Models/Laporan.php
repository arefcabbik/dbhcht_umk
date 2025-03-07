<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    
    protected $fillable = [
        'opd_id',
        'kegiatan_id',
        'tahun',
        'bulan',
        'target',
        'realisasi',
        'anggaran',
        'realisasi_anggaran',
        'keterangan'
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Rkp::class, 'kegiatan_id');
    }
} 